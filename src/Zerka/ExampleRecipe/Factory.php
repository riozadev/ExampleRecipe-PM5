<?php

declare(strict_types=1);

namespace Zerka\ExampleRecipe;

use pocketmine\crafting\ExactRecipeIngredient;
use pocketmine\crafting\PotionTypeRecipe;
use pocketmine\crafting\FurnaceType;
use pocketmine\crafting\FurnaceRecipe;
use pocketmine\crafting\ShapedRecipe;

use pocketmine\block\VanillaBlocks;
use pocketmine\item\VanillaItems;
use pocketmine\item\Item;

class Factory {

    /** @var Loader */
    public Loader $loader;

    /**
     * @param \Zerka\ExampleRecipe\Loader $loader
     */
    public function __construct(Loader $loader){
        $this->loader = $loader;

        $this->examplePotionRecipe();
        $this->exampleSmokerRecipe();
        $this->exampleShapedRecipe();

    }

    /**
     * @return void
     */
    private function examplePotionRecipe() : void {
        self::registerPotionRecipe($this->loader, VanillaItems::GLASS_BOTTLE(), VanillaItems::ECHO_SHARD(), VanillaItems::BREAD());
    }

    /**
     * @return void
     */
    private function exampleSmokerRecipe() : void {
        self::registerSmokerRecipe($this->loader, VanillaItems::ECHO_SHARD(), VanillaItems::BREAD());
    }

    /**
     * @return void
     */
    private function exampleShapedRecipe() : void {
        self::registerShapedRecipe($this->loader, ["BCB", "DAE", "BCB"], ["A" => VanillaItems::ECHO_SHARD(), "B" => VanillaItems::BLAZE_POWDER(), "C" => VanillaBlocks::VINES()->asItem(), "D" => VanillaBlocks::NETHER_WART()->asItem(), "E" => VanillaBlocks::AZURE_BLUET()->asItem()], [VanillaItems::BREAD()]); 
    }

    /**
     * @param \Zerka\ExampleRecipe\Loader $loader
     * @param \pocketmine\item\Item $inputBottle
     * @param \pocketmine\item\Item $ingredient
     * @param \pocketmine\item\Item $result
     * @return void
     */
    private static function register(Loader $loader, Item $inputBottle, Item $ingredient, Item $result): void
    {
        $loader->getServer()->getCraftingManager()->registerPotionTypeRecipe(
            new PotionTypeRecipe(
                new ExactRecipeIngredient($inputBottle),
                new ExactRecipeIngredient($ingredient),
                $result
            )
        );
    }

    /**
     * @param \Zerka\ExampleRecipe\Loader $loader
     * @param \pocketmine\item\Item $input
     * @param \pocketmine\item\Item $result
     * @return void
     */
    private static function registerSmokerRecipe(Loader $loader, Item $input, Item $result): void
    {
        $loader->getServer()->getCraftingManager()->getFurnaceRecipeManager(FurnaceType::SMOKER())->register(
            new FurnaceRecipe(
                $result,
                new ExactRecipeIngredient($input)
            )
        );
    }

    /**
     * @param \Zerka\ExampleRecipe\Loader $loader
     * @param array $shape
     * @param array $ingredients
     * @param array $result
     * @return void
     */
    private static function registerShapedRecipe(Loader $loader, array $shape, array $ingredients, array $result): void
    {
        $loader->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe(
            $shape,
            array_map(fn(Item $item) => new ExactRecipeIngredient($item), $ingredients),
            $result
        ));
    }
    
}