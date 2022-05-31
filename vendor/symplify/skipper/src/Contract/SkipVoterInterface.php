<?php

declare (strict_types=1);
namespace ECSPrefix20220531\Symplify\Skipper\Contract;

use ECSPrefix20220531\Symplify\SmartFileSystem\SmartFileInfo;
interface SkipVoterInterface
{
    /**
     * @param string|object $element
     */
    public function match($element) : bool;
    /**
     * @param string|object $element
     */
    public function shouldSkip($element, \ECSPrefix20220531\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool;
}
