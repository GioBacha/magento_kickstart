<?php declare(strict_types=1);

namespace Macademy\BlogExtra\Plugin;

use Macademy\Blog\Observer\LogPostDetailView;

class PreventPostDetailLogger
{

    public function aroundExecute(
        LogPostDetailView $subject,
        callable          $proceed,
    )
    {
        // do not do anything to prevent logger from executing
    }

}
