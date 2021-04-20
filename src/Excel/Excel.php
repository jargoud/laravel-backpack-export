<?php

namespace Jargoud\LaravelBackpackExport\Excel;

use Maatwebsite\Excel\Excel as BaseExcel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Excel extends BaseExcel
{
    /**
     * @param object $export
     * @param string $fileName
     * @param string|null $writerType
     * @param array $headers
     * @return StreamedResponse
     */
    public function download($export, string $fileName, string $writerType = null, array $headers = [])
    {
        return response()->streamDownload(
            function () use ($export, $fileName, $writerType): void {
                $this->export($export, $fileName, $writerType);
            },
            $fileName,
            $headers
        );
    }
}
