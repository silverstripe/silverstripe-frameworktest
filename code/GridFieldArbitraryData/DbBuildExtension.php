<?php

namespace SilverStripe\FrameworkTest\GridFieldArbitraryData;

use SilverStripe\Control\Director;
use SilverStripe\Core\Extension;
use SilverStripe\Dev\Command\DbBuild;
use SilverStripe\PolyExecution\PolyOutput;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\Queries\SQLSelect;

/**
 * Builds the table and adds default records for the ArbitraryDataModel.
 */
class DbBuildExtension extends Extension
{
    /**
     * This extension hook is on TestSessionEnvironment, which is used by behat but not by phpunit.
     * For whatever reason, behat doesn't build the db, so we can't rely on the below onAfterbuild
     * being run in that scenario.
     */
    protected function onAfterStartTestSession()
    {
        $output = PolyOutput::create(
            Director::is_cli() ? PolyOutput::FORMAT_ANSI : PolyOutput::FORMAT_HTML,
            PolyOutput::VERBOSITY_QUIET
        );
        $output->startList();
        $this->buildTable($output);
        $output->stopList();
        $this->populateData();
    }

    /**
     * This extension hook is on DbBuild, after building the database.
     */
    protected function onAfterBuild(PolyOutput $output, bool $populate, bool $testMode): void
    {
        if ($testMode) {
            return;
        }

        $output->writeln('<options=bold>Creating table for frameworktest arbitrary data</>');
        $output->startList();
        $this->buildTable($output);
        $output->stopList();
        if ($populate) {
            $output->writeln('<options=bold>Creating database records arbitrary data</>');
            $output->startList();
            $this->populateData();
            $output->stopList();
        }
        $output->writeln(['<options=bold>Frameworktest database build completed!</>', '']);
    }

    private function buildTable(PolyOutput $output): void
    {
        $tableName = ArbitraryDataModel::TABLE_NAME;

        // Log data
        $showRecordCounts = DbBuild::config()->get('show_record_counts');
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
        // We're adding one list item, but we need to do it this way for consistency
        // with the rest of the db build output
        $output->writeListItem($tableName . $countSuffix);

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
