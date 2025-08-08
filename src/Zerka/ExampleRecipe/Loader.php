<?php

declare(strict_types=1);

namespace Zerka\ExampleRecipe;

use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {

    public function onEnable() : void { new Factory($this); }
}