<?php

namespace BinaLinq\DataSynchronize\PanelSections;

use BinaLinq\Base\PanelSections\PanelSection;

class ImportPanelSection extends PanelSection
{
    public function setup(): void
    {
        $this
            ->setId('data-synchronize-import')
            ->setTitle(trans('packages/data-synchronize::data-synchronize.import.name'))
            ->withPriority(99999);
    }
}
