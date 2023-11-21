<?php

namespace SilverStripe\FrameworkTest\GridFieldArbitraryData;

use SilverStripe\Control\Director;
use SilverStripe\Core\Extension;
use SilverStripe\ORM\DatabaseAdmin;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\Queries\SQLSelect;

/**
 * Builds the table and adds default records for the ArbitraryDataModel.
 */
class DatabaseBuildExtension extends Extension
{
    /**
     * This extension hook is on TestSessionEnvironment, which is used by behat but not by phpunit.
     * For whatever reason, behat doesn't use dev/build, so we can't rely on the below onAfterbuild
     * being run in that scenario.
     */
    protected function onAfterStartTestSession()
    {
        $this->buildTable(true);
        $this->populateData();
    }

    /**
     * This extension hook is on DatabaseAdmin, after dev/build has finished building the database.
     */
    protected function onAfterBuild(bool $quiet, bool $populate, bool $testMode): void
    {
        if ($testMode) {
            return;
        }

        if (!$quiet) {
            if (Director::is_cli()) {
                echo "\nCREATING TABLE FOR FRAMEWORKTEST ARBITRARY DATA\n\n";
            } else {
                echo "\n<p><b>Creating table for frameworktest arbitrary data</b></p><ul>\n\n";
            }
        }

        $this->buildTable($quiet);

        if (!$quiet && !Director::is_cli()) {
            echo '</ul>';
        }

        if ($populate) {
            if (!$quiet) {
                if (Director::is_cli()) {
                    echo "\nCREATING DATABASE RECORDS FOR FRAMEWORKTEST ARBITRARY DATA\n\n";
                } else {
                    echo "\n<p><b>Creating database records arbitrary data</b></p><ul>\n\n";
                }
            }

            $this->populateData();

            if (!$quiet && !Director::is_cli()) {
                echo '</ul>';
            }
        }

        if (!$quiet) {
            echo (Director::is_cli()) ? "\n Frameworktest database build completed!\n\n" : '<p>Frameworktest database build completed!</p>';
        }
    }

    private function buildTable(bool $quiet): void
    {
        $tableName = ArbitraryDataModel::TABLE_NAME;

        // Log data
        if (!$quiet) {
            $showRecordCounts = DatabaseAdmin::config()->get('show_record_counts');
            if ($showRecordCounts && DB::get_schema()->hasTable($tableName)) {
                try {
                    $count = SQLSelect::create()->setFrom($tableName)->count();
                    $countSuffix = " ($count records)";
                } catch (\Exception $e) {
                    $countSuffix = ' (error getting record count)';
                }
            } else {
                $countSuffix = "";
            }

            if (Director::is_cli()) {
                echo " * $tableName$countSuffix\n";
            } else {
                echo "<li>$tableName$countSuffix</li>\n";
            }
        }

        // Get field schema
        $fields = [
            'ID' => 'PrimaryKey',
            'LastEdited' => 'DBDatetime',
            'Created' => 'DBDatetime',
        ];
        $fieldNames = array_keys(ArbitraryDataAdmin::getInitialRecords()[0]);
        foreach ($fieldNames as $fieldName) {
            if ($fieldName === 'ID') {
                continue;
            }
            $fields[$fieldName] = 'Varchar';
        }

        // Write the table to the database
        DB::get_schema()->schemaUpdate(function () use ($tableName, $fields) {
            DB::require_table(
                $tableName,
                $fields,
                null,
                true,
                DataObject::config()->get('create_table_options')
            );
        });
    }

    private function populateData(): void
    {
        $tableName = ArbitraryDataModel::TABLE_NAME;
        $count = SQLSelect::create()->setFrom($tableName)->count();

        if ($count <= 0) {
            $now = DBDatetime::now()->Rfc2822();
            $data = ArbitraryDataAdmin::getInitialRecords();
            foreach ($data as $record) {
                unset($record['ID']);
                $record['LastEdited'] = $now;
                $record['Created'] = $now;

                $item = ArbitraryDataModel::create($record);
                $item->write();
            }

            DB::alteration_message('Added default records for frameworktest arbitrary data', 'created');
        }
    }
}
