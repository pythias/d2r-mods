<?php
require __DIR__ . '/../vendor/autoload.php';

use Mod\Sys;
use Mod\Log;

$tag = isset($argv[1]) ? "full" : "default";
$defaultFile = PATH_DATA_MY . "/hd/roomtiles/entry_{$tag}.json";
$template = Mod\File\Json::decode($defaultFile);
$rooms = [
    "act_1_catacombs_down",
    "act_1_cave_down",
    "act_1_cave_up",
    "act_1_crypt_down",
    "act_1_graveyard_to_crypt_1",
    "act_1_graveyard_to_crypt_2",
    "act_1_jail_down",
    "act_1_jail_up",
    "act_1_tower_to_crypt",
    "act_1_tower_to_wilderness",
    "act_1_wilderness_to_cave_cliff_l",
    "act_1_wilderness_to_cave_cliff_r",
    "act_1_wilderness_to_cave_floor_l",
    "act_1_wilderness_to_cave_floor_r",
    "act_1_wilderness_to_tower",
    "act_2_basement_down",
    "act_2_desert_to_lair",
    "act_2_desert_to_sewer_trap",
    "act_2_desert_to_tomb_l_1",
    "act_2_desert_to_tomb_l_2",
    "act_2_desert_to_tomb_r_1",
    "act_2_desert_to_tomb_r_2",
    "act_2_desert_to_tomb_tal_1",
    "act_2_desert_to_tomb_tal_2",
    "act_2_desert_to_tomb_tal_3",
    "act_2_desert_to_tomb_tal_4",
    "act_2_desert_to_tomb_tal_5",
    "act_2_desert_to_tomb_tal_6",
    "act_2_desert_to_tomb_tal_7",
    "act_2_desert_to_tomb_viper",
    "act_2_harem_down_1",
    "act_2_harem_down_2",
    "act_2_lair_down",
    "act_2_sewer_dock_to_town",
    "act_2_sewer_down",
    "act_2_tomb_down",
    "act_3_dungeon_down",
    "act_3_jungle_to_dungeon_fort",
    "act_3_jungle_to_dungeon_hole",
    "act_3_jungle_to_spider",
    "act_3_kurast_to_temple",
    "act_3_mephisto_down_l",
    "act_3_mephisto_down_r",
    "act_3_sewer_down",
    "act_4_mesa_to_lava",
    "act_5_baal_temple_down_l",
    "act_5_baal_temple_down_r",
    "act_5_barricade_down_floor",
    "act_5_barricade_down_wall_l",
    "act_5_barricade_down_wall_r",
    "act_5_ice_caves_down_floor",
    "act_5_ice_caves_down_l",
    "act_5_ice_caves_down_r",
    "act_5_temple_down",
];

foreach ($rooms as $room) {
    $file = PATH_DATA_MY . "/hd/roomtiles/" . $room . ".json";
    $template['name'] = $room;

    if (!Mod\File\Json::encode($file, $template)) {
        Log::error("can't merge file '{$file}'");
    }
}
