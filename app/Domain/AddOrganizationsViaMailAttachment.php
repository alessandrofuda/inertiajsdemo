<?php


namespace App\Domain;


use App\Models\Organization;
use Illuminate\Support\Facades\Log;

class AddOrganizationsViaMailAttachment // implements AddOrganizationsInterface INTERFACE ? .. TODO
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

//    private function checkCsvHeader() {
//
//    }
    private function checkCsvData() {

//        if (!$this->attachment_body) {
//            return false;
//        }
//        $columns = explode(';', $this->attachment_body);
//
//        // check: 9 fields && first column is integer TODO
//        if (count($columns) === 9 && is_int($columns[0])) {
//            return true;
//        }
//        return false;
        return true;
    }

    private function convertCsvToArray(): array {
        $data_array = [];
        $csv_lines = explode(PHP_EOL, $this->attachment_body);
        foreach ($csv_lines as $csv_line) {
            $data_array[] = str_getcsv($csv_line, ';');
        }

        Log::info(print_r($data_array));

        return $data_array;
    }
    public function insertCsvInDb()
    {
        if($this->checkCsvData()) {
            $organizations = $this->convertCsvToArray();

            // Organization::create()

            dd('ok');
        }
        return response()->json(['status'=>'ok'], 200);
    }
}
