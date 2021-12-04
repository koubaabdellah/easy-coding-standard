<?php

declare (strict_types=1);
namespace ECSPrefix20211204\Symplify\Skipper\Skipper;

use ECSPrefix20211204\Symplify\Skipper\Contract\SkipVoterInterface;
use ECSPrefix20211204\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @api
 * @see \Symplify\Skipper\Tests\Skipper\Skipper\SkipperTest
 */
final class Skipper
{
    /**
     * @var string
     */
    private const FILE_ELEMENT = 'file_elements';
    /**
     * @var \Symplify\Skipper\Contract\SkipVoterInterface[]
     */
    private $skipVoters;
    /**
     * @param SkipVoterInterface[] $skipVoters
     */
    public function __construct(array $skipVoters)
    {
        $this->skipVoters = $skipVoters;
    }
    /**
     * @param object|string $element
     */
    public function shouldSkipElement($element) : bool
    {
        $fileInfo = new \ECSPrefix20211204\Symplify\SmartFileSystem\SmartFileInfo(__FILE__);
        return $this->shouldSkipElementAndFileInfo($element, $fileInfo);
    }
    public function shouldSkipFileInfo(\ECSPrefix20211204\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        return $this->shouldSkipElementAndFileInfo(self::FILE_ELEMENT, $smartFileInfo);
    }
    /**
     * @param object|string $element
     */
    public function shouldSkipElementAndFileInfo($element, \ECSPrefix20211204\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : bool
    {
        foreach ($this->skipVoters as $skipVoter) {
            if ($skipVoter->match($element)) {
                return $skipVoter->shouldSkip($element, $smartFileInfo);
            }
        }
        return \false;
    }
}
