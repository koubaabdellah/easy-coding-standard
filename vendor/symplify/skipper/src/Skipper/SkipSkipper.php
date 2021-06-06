<?php

declare (strict_types=1);
namespace ECSPrefix20210606\Symplify\Skipper\Skipper;

use ECSPrefix20210606\Symplify\Skipper\Matcher\FileInfoMatcher;
use ECSPrefix20210606\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\Skipper\Tests\Skipper\Skip\SkipSkipperTest
 */
final class SkipSkipper
{
    /**
     * @var FileInfoMatcher
     */
    private $fileInfoMatcher;
    public function __construct(\ECSPrefix20210606\Symplify\Skipper\Matcher\FileInfoMatcher $fileInfoMatcher)
    {
        $this->fileInfoMatcher = $fileInfoMatcher;
    }
    /**
     * @param object|string $checker
     * @param array<string, string[]|null> $skippedClasses
     */
    public function doesMatchSkip($checker, \ECSPrefix20210606\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, array $skippedClasses) : bool
    {
        foreach ($skippedClasses as $skippedClass => $skippedFiles) {
            if (!\is_a($checker, $skippedClass, \true)) {
                continue;
            }
            // skip everywhere
            if (!\is_array($skippedFiles)) {
                return \true;
            }
            if ($this->fileInfoMatcher->doesFileInfoMatchPatterns($smartFileInfo, $skippedFiles)) {
                return \true;
            }
        }
        return \false;
    }
}