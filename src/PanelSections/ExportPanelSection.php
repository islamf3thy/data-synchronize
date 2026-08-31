<?php

namespace BinaLinq\DataSynchronize\PanelSections;

use BinaLinq\Base\PanelSections\PanelSection;

class ExportPanelSection extends PanelSection
{
    public function setup(): void
    {
        $this
            ->setId('data-synchronize-export')
            ->setTitle(trans('packages/data-synchronize::data-synchronize.export.name'))
            ->withPriority(99999);
    }
}
