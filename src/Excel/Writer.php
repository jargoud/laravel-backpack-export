<?php

namespace Jargoud\LaravelBackpackExport\Excel;

use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Factories\WriterFactory;
use Maatwebsite\Excel\Files\RemoteTemporaryFile;
use Maatwebsite\Excel\Files\TemporaryFile;
use Maatwebsite\Excel\Writer as BaseWriter;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Exception as WriterException;

class Writer extends BaseWriter
{
    /**
     * @param object $export
     * @param TemporaryFile $temporaryFile
     * @param string $writerType
     * @return TemporaryFile
     * @throws WriterException
     * @throws Exception
     */
    public function write($export, TemporaryFile $temporaryFile, string $writerType): TemporaryFile
    {
        $this->exportable = $export;

        $this->spreadsheet->setActiveSheetIndex(0);

        $this->raise(new BeforeWriting($this, $this->exportable));

        WriterFactory
            ::make(
                $writerType,
                $this->spreadsheet,
                $export
            )
            ->save("php://output");

        if ($temporaryFile instanceof RemoteTemporaryFile) {
            $temporaryFile->updateRemote();
        }

        $this->spreadsheet->disconnectWorksheets();
        unset($this->spreadsheet);

        return $temporaryFile;
    }
}
