<?php

namespace BinaLinq\DataSynchronize\Http\Requests;

use BinaLinq\Support\Http\Requests\Request;

class DownloadTemplateRequest extends Request
{
    public function rules(): array
    {
        return [
            'format' => ['required', 'string', 'in:csv,xlsx'],
        ];
    }
}
