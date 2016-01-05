<?php
namespace Skimia\LaPoste\Traits;
use Symfony\Component\Finder\Finder;

trait FilesTrait{

    public function directories($directory)
    {
        $directories = array();

        foreach (Finder::create()->in($directory)->directories()->depth(0) as $dir)
        {
            $directories[] = $dir->getPathname();
        }

        return $directories;
    }

    public function allFiles($directory)
    {
        return iterator_to_array(Finder::create()->files()->in($directory), false);
    }
}