<?php

namespace BinaLinq\DataSynchronize\Table\HeaderActions;

use BinaLinq\Table\HeaderActions\HeaderAction;

class ExportHeaderAction extends HeaderAction
{
    public static function make(string $name = 'export'): static
    {
        return parent::make($name)
            ->label(trans('packages/data-synchronize::data-synchronize.export.name'))
            ->icon('ti ti-file-export');
    }
}
