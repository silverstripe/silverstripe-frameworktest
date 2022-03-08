<?php

use SilverStripe\Assets\File;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\Image;
use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use SilverStripe\Core\Path;
use SilverStripe\Core\Manifest\ModuleResourceLoader;

/**
 * Creates sample folder and file structure, useful to test performance,
 * UI behaviour on deeply nested structures etc.
 *
 * Downloads around 20MB of data from a public web location on first run,
 * in order to create reasonable fixture data (and keep it out of the module repo).
 * The related AWS S3 bucket is managed by SilverStripe Ltd.
 *
 * Protip: In case you want to test thumbnail generation, you can
 * recursively delete any generated ones through the following bash command in `assets/`:
 * `find . -name '*Resampled*' -print0 | xargs -0 rm`
 *
 * Parameters:
 *  - reset=1: Optionally truncate ALL files and folders in the database, plus delete
 *    the entire `assets/` directory.
 *
 *
 * Configuration
 *
 * app/_config/frameworktest.yml
 *
 * The following yml config make 1040 files / 520mb:
 *
 * To make 100K records, increase the base folderCountByDepth from 1 to 100 and run the task overnight
 *
 *  ```
 * FTFileMakerTask:
 *   documentsOnly: true
 *   doSetFolderPermissions: true
 *   doSetOldCreationDate: false
 *   doRandomlyPublish: false
 *   depth: 3
 *   folderCountByDepth:
 *     - 1
 *     - 9
 *     - 7
 *     - 0
 *     - 0
 *   fileCountByDepth:
 *     - 50
 *     - 25
 *     - 20
 *     - 0
 *     - 0
 *
 * Flush and run:
 * /dev/tasks/FTFileMakerTask?flush&reset=1
 *
 * @todo Automatically retrieve file listing from S3
 * @todo Handle HTTP errors from S3
 */
class FTFileMakerTask extends BuildTask
{
    /**
     * If set to TRUE skip thumbnail generation
     * @var bool
     * @config
     */
    private static $documentsOnly = false;

    /**
     * Vary the permission on the folders
     * @var bool
     * @config
     */
    private static $doSetFolderPermissions = true;

    /**
     * Put some files in wrong store to test logic meant to correct this kind of problem..
     * @var bool
     * @config
     */
    private static $doPutProtectedFilesInPublicStore = false;

    /**
     * Set the date of some files to an old date.
     * @var bool
     * @config
     */
    private static $doSetOldCreationDate = true;

    /**
     * Publish some files.
     * @var bool
     * @config
     */
    private static $doRandomlyPublish = true;

    /**
     * How deep should or folder hierachy be.
     * @var int
     * @config
     */
    private static $depth = 2;

    /**
     * When true, watermark images for unique image binary per Image record
     * @var bool
     * @config
     */
    private static $uniqueImages = true;

    /**
     * Number of folders to create certain hierarchy.
     * @var int[]
     * @config
     */
    private static $folderCountByDepth = [
        0 => 2,
        1 => 2,
        2 => 2,
        3 => 2,
        4 => 2,
    ];

    /**
     * Number of files to create at various depths in the hierachy
     * @var int[]
     * @config
     */
    private static $fileCountByDepth = [
        0 => 100,
        1 => 30,
        2 => 5,
        3 => 5,
        4 => 5,
    ];

    protected $fixtureFileBaseUrl = "https://s3-ap-southeast-2.amazonaws.com/silverstripe-frameworktest-assets/";

    protected $defaultImageFileName = 'image-huge-tall.jpg';

    protected $fixtureFileNames = [
        'archive.zip',
        'animated.gif',
        'document.docx',
        'document.pdf',
        'image-huge-tall.jpg',
        'image-huge-wide.jpg',
        'image-large.jpg',
        'image-large.png',
        'image-large.gif',
        'image-medium.jpg',
        'image-small.jpg',
        'image-tiny.jpg',
        'image-medium.bmp',
        'spreadsheet.xlsx',
        'video.m4v'
    ];

    protected $fixtureFileTypes = [
        'archive.zip' => 'SilverStripe\Assets\File',
        'animated.gif' => 'SilverStripe\Assets\Image',
        'document.docx' => 'SilverStripe\Assets\File',
        'document.pdf' => 'SilverStripe\Assets\File',
        'image-huge-tall.jpg' => 'SilverStripe\Assets\Image',
        'image-huge-wide.jpg' => 'SilverStripe\Assets\Image',
        'image-large.jpg' => 'SilverStripe\Assets\Image',
        'image-large.png' => 'SilverStripe\Assets\Image',
        'image-large.gif' => 'SilverStripe\Assets\Image',
        'image-medium.jpg' => 'SilverStripe\Assets\Image',
        'image-small.jpg' => 'SilverStripe\Assets\Image',
        'image-tiny.jpg' => 'SilverStripe\Assets\Image',
        'image-medium.bmp' => 'SilverStripe\Assets\File',
        'spreadsheet.xlsx' => 'SilverStripe\Assets\File',
        'video.m4v' => 'SilverStripe\Assets\File',
    ];

    protected $lineBreak = "\n<br>";

    /** @var Member */
    protected $anonymousMember = null;

    /**
     * Allow override of the fileCountByDepth
     * @var array
     */
    protected $fileCounts = [];

    /**
     * Allow override of the folderCountByDepth
     * @var array
     */
    protected $folderCounts = [];

    public function run($request)
    {
        set_time_limit(0);

        // used to test canView() permissions
        $this->anonymousMember = Member::get()->find('Email', 'frameworktestuser');
        if (!$this->anonymousMember) {
            $this->anonymousMember = Member::create();
            $this->anonymousMember->Email = 'frameworktestuser';
            $this->anonymousMember->write();
        }
        if (!$this->anonymousMember->inGroup('content-authors')) {
            $this->anonymousMember->addToGroupByCode('content-authors');
        }
        Security::setCurrentUser($this->anonymousMember);

        if (php_sapi_name() == "cli") {
            $this->lineBreak = "\n";
        }

        if ($request->getVar('reset')) {
            $this->reset();
        }

        $fileCounts = $request->getVar('fileCounts');
        if ($fileCounts) {
            $counts = explode(',', $fileCounts);
            $this->fileCounts = array_map(function ($int) {
                return (int) trim($int);
            }, $counts);
        } else {
            $this->fileCounts = self::config()->get('fileCountByDepth');
        }

        $folderCounts = $request->getVar('folderCounts');
        if ($folderCounts) {
            $counts = explode(',', $folderCounts);
            $this->folderCounts = array_map(function ($int) {
                return (int) trim($int);
            }, $counts);
        } else {
            $this->folderCounts = self::config()->get('folderCountByDepth');
        }

        echo "Downloading fixtures" . $this->lineBreak;
        $fixtureFilePaths = $this->downloadFixtureFiles();

        if (!self::config()->get('documentsOnly')) {
            echo "Generate thumbnails" . $this->lineBreak;
            $this->generateThumbnails($fixtureFilePaths);
        }

        echo "Generate files" . $this->lineBreak;
        $this->generateFiles($fixtureFilePaths);

        if (!self::config()->get('doPutProtectedFilesInPublicStore')) {
            echo "Incorrectly putting protected files into public asset store on purpose" . $this->lineBreak;
            $this->putProtectedFilesInPublicAssetStore();
        }
    }

    protected function reset()
    {
        echo "Resetting assets" . $this->lineBreak;

        DB::query('TRUNCATE "File"');
        DB::query('TRUNCATE "File_Live"');
        DB::query('TRUNCATE "File_Versions"');

        if (file_exists(ASSETS_PATH) && ASSETS_PATH && ASSETS_PATH !== '/') {
            exec("rm -rf " . ASSETS_PATH);
        }
    }

    protected function downloadFixtureFiles()
    {
        $client = new Client(['base_uri' => $this->fixtureFileBaseUrl]);

        $fixtureFileNames = $this->fixtureFileNames;
        if (self::config()->get('documentsOnly')) {
            $fixtureFileNames = array_filter($fixtureFileNames, function($v) {
                return (bool) preg_match('%\.(docx|xlsx|pdf)$%', $v);
            });
        }

        // Initiate each request but do not block
        $promises = [];
        $paths = [];
        foreach ($fixtureFileNames as $filename) {
            $path = TEMP_FOLDER . '/' . $filename;
            $paths[$filename] = $path;
            $url = "{$this->fixtureFileBaseUrl}/{$filename}";
            if (!file_exists($path)) {
                $promises[$filename] = $client->getAsync($filename, [
                    'sink' => $path
                ]);
                echo "Downloading $url" . $this->lineBreak;
            }
        }

        // Wait on all of the requests to complete. Throws a ConnectException
        // if any of the requests fail
        Utils::unwrap($promises);

        return $paths;
    }

    /**
     * Creates thumbnails of sample images
     *
     * @param array $fixtureFilePaths
     */
    protected function generateThumbnails($fixtureFilePaths)
    {
        $folder = Folder::find_or_make('testfolder-thumbnail');
        $fileName = $this->defaultImageFileName;

        foreach(['draft', 'published'] as $state) {
            $file = new Image([
                'ParentID' => $folder->ID,
                'Title' => "{$fileName} {$state}",
                'Name' => $fileName,
            ]);
            $file->File->setFromLocalFile($fixtureFilePaths[$fileName], $folder->getFilename() . $fileName);
            $file->write();

            if ($state === 'published') {
                $file->publishFile();
            }

            $file->Pad(60, 60)->CropHeight(30);
        }
    }

    protected function generateFiles($fixtureFilePaths, $depth = 0, $prefix = "0", $parentID = 0)
    {

        $folderCount = $this->folderCounts[$depth];
        $fileCount = $this->fileCounts[$depth];

        $doSetFolderPermissions = (bool) self::config()->get('doSetFolderPermissions');

        $doSetOldCreationDate = (bool) self::config()->get('doSetOldCreationDate');
        $doRandomlyPublish = (bool) self::config()->get('doRandomlyPublish');

        $uniqueImages = (bool) self::config()->get('uniqueImages');
        $watermarkPath = ModuleResourceLoader::singleton()->resolvePath(
            'silverstripe/frameworktest: images/silverstripe.png'
        );
        $absWatermarkPath = Path::join(BASE_PATH, $watermarkPath);

        for ($i = 1; $i <= $folderCount; $i++) {
            $folder = new Folder([
                'ParentID' => $parentID,
                'Title' => "testfolder-{$prefix}{$i}",
                'Name' => "testfolder-{$prefix}{$i}",
            ]);
            if ($doSetFolderPermissions) {
                if ($i === 1) {
                    // the first folder should always be public to ensure there's some public folders
                    $folder->CanViewType = 'Inherit';
                } elseif ($i === $folderCount) {
                    // the last folder should always be protected to ensure there's some protected folders
                    $folder->CanViewType = 'OnlyTheseUsers';
                } else {
                    // all the other folder have a 33% chance of being a protected folder
                    $folder->CanViewType = rand(0, 2) === 0 ? 'OnlyTheseUsers' : 'Inherit';
                }
            }

            $folder->write();

            for ($j = 1; $j <= $fileCount; $j++) {
                $randomFileName = array_keys($fixtureFilePaths)[rand(0, count($fixtureFilePaths) - 1)];
                $randomFilePath = $fixtureFilePaths[$randomFileName];

                $fileName = pathinfo($randomFilePath, PATHINFO_FILENAME)
                    . "-{$prefix}-{$j}"
                    . "."
                    . pathinfo($randomFilePath, PATHINFO_EXTENSION);

                // Add a random prefix to avoid all types of files showing up on a single screen page
                $fileName = substr(md5($fileName), 0, 5) . '-' . $fileName;

                $class = $this->fixtureFileTypes[$randomFileName];

                // If we're uniquifying images, copy the path and watermark it.
                if ($class === Image::class && $uniqueImages) {
                    $copyPath = Path::join(dirname($randomFilePath), $fileName);
                    copy($randomFilePath, $copyPath);
                    $newPath = $this->watermarkImage($absWatermarkPath, $copyPath);
                    if ($newPath) {
                        $randomFilePath = $newPath;
                    }
                }

                $file = new $class([
                    'ParentID' => $folder->ID,
                    'Title' => $fileName,
                    'Name' => $fileName,
                ]);
                $file->File->setFromLocalFile($randomFilePath, $folder->getFilename() . $fileName);


                // Randomly set old created date (for testing)
                if ($doSetOldCreationDate) {
                    if (rand(0, 10) === 0) {
                        $file->Created = '2010-01-01 00:00:00';
                        $file->Title = '[old] ' . $file->Title;
                    }
                }

                $file->write();

                if ($doRandomlyPublish) {
                    if (rand(0, 1) === 0) {
                        $file->publishFile();
                    }
                } else {
                    // publish files that should be viewable
                    if ($file->canView($this->anonymousMember)) {
                        $url = $file->getAbsoluteURL();
                        $file->publishFile();
                    }
                }
            }

            if ($depth < self::config()->get('depth') - 1) {
                $this->generateFiles($fixtureFilePaths, $depth + 1, "{$prefix}-{$i}", $folder->ID);
            }
        }
    }

    protected function putProtectedFilesInPublicAssetStore()
    {
        /** @var File $file */
        foreach (File::get()->exclude(['ClassName' => Folder::class]) as $file) {
            // file is already in public asset store
            if ($file->canView($this->anonymousMember)) {
                continue;
            }
            // randomly move 50% of the files that should be in the protected store to the public store
            if (rand(0, 1) == 0) {
                continue;
            }
            // this will move the file into the public asset store, even it it should be protected
            // i.e. the parent folder CanViewType = OnlyTheseUsers
            $file->publishFile();
            $url = $file->getAbsoluteURL();
        }
    }

    /**
     * @param string $stampPath
     * @param string $targetPath
     * @return null
     */
    protected function watermarkImage(string $stampPath, string $targetPath): ?string
    {
        // Load the stamp and the photo to apply the watermark to
        $ext = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        $functions = null;
        if (in_array($ext, ['jpeg', 'jpg'])) {
            $functions = ['imagecreatefromjpeg', 'imagejpeg'];
        } elseif ($ext === 'png') {
            $functions = ['imagecreatefrompng', 'imagepng'];
        }
        if (!$functions) {
            return null;
        }

        $stamp = imagecreatefrompng($stampPath);
        $targetImage = call_user_func($functions[0], $targetPath);

        // Set the margins for the stamp and get the height/width of the stamp image
        $targetX = imagesx($targetImage);
        $targetY = imagesy($targetImage);
        $stampX = imagesx($stamp);
        $stampY = imagesy($stamp);

        $marge_right = rand($stampX, $targetX - $stampX);
        $marge_bottom = rand($stampY, $targetY - $stampY);

        // Copy the stamp image onto our photo using the margin offsets and the photo
        // width to calculate positioning of the stamp.
        imagecopy(
            $targetImage,
            $stamp,
            $targetX - $stampX - $marge_right,
            $targetY - $stampY - $marge_bottom,
            0,
            0,
            $stampX,
            $stampY
        );
        call_user_func($functions[1], $targetImage, $targetPath);

        return $targetPath;
    }

}
