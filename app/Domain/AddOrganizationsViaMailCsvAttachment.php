<?php


namespace App\Domain;


use App\Models\Organization;
use Illuminate\Support\Facades\Log;

class AddOrganizationsViaMailCsvAttachment // implements AddOrganizationsInterface INTERFACE ? .. TODO
{
    protected $attachment_body;

    /**
     * HandleAttachment constructor.
     *
     * @param string $attachment_body
     *
     */
    public function __construct(string $attachment_body)
    {
        $this->attachment_body = $attachment_body;
        Log::info('Attachment body: '.$this->attachment_body);
    }

    private function checkCsvData() {

        if (!$this->attachment_body) {
            return false;
        }
//        $columns = explode(';', $this->attachment_body);
//
//        // check: 9 fields && first column is integer TODO
//        if (count($columns) === 9 && is_int($columns[0])) {
//            return true;
//        }
//        return false;
        return true;
    }

    private function convertCsvToArray() {
        $data_array = [];
        $csv_lines = explode(PHP_EOL, $this->attachment_body);
        foreach ($csv_lines as $csv_line) {
            $data_array[] = str_getcsv($csv_line, ';');
        }
        $organizations = $this->convertDataArrayToAssociativeArrays($data_array);
        return $organizations;
    }

    private function convertDataArrayToAssociativeArrays($data_array) {
        $fields = $data_array[0];
        $organizations = array_slice($data_array,1); // get data without headers
        $organizations_ass_array = [];
        foreach ($organizations as $organization_items) {
            $organization = [];
            foreach ($organization_items as $key => $organization_item) {
                $organization[$fields[$key]] = $organization_item;
            }
            $organizations_ass_array[] = $organization;
        }
        return $organizations_ass_array;
    }

    private function filter($arrays, $remove_fields) {
        $filtered = [];
        foreach ($arrays as $array) {
            $filtered[] = collect($array)->except($remove_fields)->toArray();
        }
        return $filtered;
    }

    public function insertCsvInDb() {
        if($this->checkCsvData()) {
            $organizations = $this->convertCsvToArray();
            $organizations = $this->filter($organizations, ['id','created_at','updated_at','deleted_at']);
            $created = [];
            foreach ($organizations as $organization) {
                $created[] = Organization::create($organization);
            }
        }
        return response()->json(['status'=>'ok'], 200);
    }
}
