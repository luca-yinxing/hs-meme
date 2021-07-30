<?php
// Copyright (C) 2021 Luca Gasperini <luca.gasperini@xsoftware.it>
//
// This file is part of hsmeme.net.
//
// hsmeme.net is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 2 of the License, or
// (at your option) any later version.
//
// hsmeme.net is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with hsmeme.net. If not, see <http: //www.gnu.org/licenses />.

require "config.php";

$GLOBALS["languages"] = ["deDE", "enUS", "esES", "esMX", "frFR", "itIT", "jaJP", "koKR", "plPL", "ptBR", "ruRU", "thTH", "zhCN", "zhTW"];
$GLOBALS["card_type"] = ["", "HERO", "MINION", "SPELL", "WEAPON", "HERO_POWER"];
$GLOBALS["card_set"] = [
	"", "TEST_TEMPORARY", "CORE", "EXPERT1", "HOF", "MISSIONS", "DEMO",
	"NONE", "CHEAT", "CS_BLANK", "DEBUG_SP", "PROMO", "NAXX", "GVG", "BRM", "TGT", "CREDITS", "HERO_SKINS", "TB", "SLUSH", "LOE", "OG", "OG_RESERVE", "KARA", "KARA_RESERVE", "GANGS", "GANGS_RESERVE", "UNGORO", "ICECROWN", "LOOTAPALOOZA", "GILNEAS", "BOOMSDAY", "CS_TROLL", "DALARAN", "ULDUM", "DRAGONS", "YEAR_OF_THE_DRAGON",
	"BLACK_TEMPLE", "WILD_EVENT", "SCHOLOMANCE", "BATTLEGROUNDS",
	"DEMON_HUNTER_INITIATE", "DARKMOON_FAIRE", "THE_BARRENS"
];
$GLOBALS["card_rarity"] = ["", "COMMON", "RARE", "EPIC", "LEGENDARY", "FREE"];
$GLOBALS["card_race"] = ["", "MURLOC", "DEMON", "MECHANICAL", "ELEMENTAL", "BEAST", "TOTEM", "PIRATE", "DRAGON", "ALL", "QUILBOAR"];
$GLOBALS["card_spellschool"] = ["", "NATURE", "FROST", "FIRE", "ARCANE", "FEL", "SHADOW", "HOLY"];
$GLOBALS["card_class"] = ["", "NEUTRAL", "DEMONHUNTER", "DRUID", "HUNTER", "MAGE", "PALADIN", "PRIEST", "ROGUE", "SHAMAN", "WARLOCK", "WARRIOR"];
$GLOBALS["init"] = false;


$GLOBALS["card_type_i18n"] = [
	"HERO" => ["enUS" => "Hero", "itIT" => "Eroe"],
	"MINION" => ["enUS" => "Minion", "itIT" => "Servitore"],
	"SPELL" => ["enUS" => "Spell", "itIT" => "Magia"],
	"WEAPON" => ["enUS" => "Weapon", "itIT" => "Arma"],
	"HERO_POWER" => ["enUS" => "Hero Power", "itIT" => "Potere Eroe"],
	"TILE" => ["enUS" => "Tile", "itIT" => "Miniatura"]
];

$GLOBALS["languages_i18n"] = [
	"deDE" => ["enUS" => "German", "itIT" => "Tedesco", "deDE" => "Deutsch"],
	"enUS" => ["enUS" => "English", "itIT" => "Inglese"],
	"esES" => ["enUS" => "Spanish", "itIT" => "Spagnolo"],
	"esMX" => ["enUS" => "Spanish (Mexico)", "itIT" => "Spagnolo (Messico)"],
	"frFR" => ["enUS" => "French", "itIT" => "Francese"],
	"itIT" => ["enUS" => "Italian", "itIT" => "Italiano"],
	"jaJP" => ["enUS" => "Japanese", "itIT" => "Giapponese"],
	"koKR" => ["enUS" => "Korean", "itIT" => "Coreano"],
	"plPL" => ["enUS" => "Polish", "itIT" => "Polacco"],
	"ptBR" => ["enUS" => "Portugese", "itIT" => "Portogese"],
	"ruRU" => ["enUS" => "Russian", "itIT" => "Russo"],
	"thTH" => ["enUS" => "Thai", "itIT" => "Thailandese"],
	"zhCN" => ["enUS" => "Chinese", "itIT" => "Cinese"],
	"zhTW" => ["enUS" => "Traditional Chinese", "itIT" => "Cinese Tradizionale"]
];

$GLOBALS["titles_i18n"] = [
	"template_cards" => ["enUS" => "Template Cards", "itIT" => "Modelli delle Carte"],
	"card_builder" => ["enUS" => "Card Builder", "itIT" => "Costruttore di Carte"]
];

$GLOBALS["navbar_i18n"] = [
	"/" => ["enUS" => "Home"],
	"/cardbuilder.php" => ["enUS" => "Card Builder"]
];

$GLOBALS["form_input_i18n"] = [
	"art" => ["type" => "file", "enUS" => "Art Image:", "itIT" => "Immagine:", "accept" => "image/png,image/jpeg"],
	"i" => ["type" => "text", "enUS" => "ID:", "class" => "d-none"],
	"y" => ["type" => "text", "enUS" => "Type:", "itIT" => "Tipo:", "class" => "d-none"],
	"n" => ["type" => "text", "enUS" => "Name:", "itIT" => "Nome:"],
	"t" => ["type" => "textarea", "enUS" => "Text:", "itIT" => "Testo:"],
	"c" => ["type" => "number", "enUS" => "Cost:", "itIT" => "Costo:", "min" => "0", "max" => "99"],
	"a" => ["type" => "number", "enUS" => "Attack:", "itIT" => "Attacco:", "min" => "0", "max" => "99"],
	"H" => ["type" => "number", "enUS" => "Health:", "itIT" => "Salute:", "min" => "0", "max" => "99"],
	"m" => ["type" => "number", "enUS" => "Armor:", "itIT" => "Armatura:", "min" => "0", "max" => "99"],
	"d" => ["type" => "number", "enUS" => "Durability:", "itIT" => "Durabilità:"],
	"s" => ["type" => "select", "enUS" => "Set:", "values" => $GLOBALS["card_set"]],
	"r" => ["type" => "select", "enUS" => "Rarity:", "itIT" => "Rarità:", "values" => $GLOBALS["card_rarity"]],
	"R" => ["type" => "select", "enUS" => "Race:", "itIT" => "Razza:", "values" => $GLOBALS["card_race"]],
	"S" => ["type" => "select", "enUS" => "Spellschool:", "itIT" => "Scuola di magia:", "values" => $GLOBALS["card_spellschool"]],
	"C" => ["type" => "select", "enUS" => "Class:", "itIT" => "Classe:", "values" => $GLOBALS["card_class"]],
	"submit" => ["type" => "button", "enUS" => "Render", "itIT" => "Renderizza"]
];

$GLOBALS["about_contact_title_i18n"] = [
	"enUS" => "Contact Us",
	"itIT" => "Contatti"
];

$GLOBALS["about_contact_i18n"] = [
	"enUS" => "<p>You can find me and write me here:</p>",
	"itIT" => "<p>Puoi trovarmi e scrivermi qui:</p>"
];

$GLOBALS["about_contrib_title_i18n"] = [
	"enUS" => "How to Contribute",
	"itIT" => "Come Contribuire"
];

$GLOBALS["about_contrib_i18n"] = [
	"enUS" => "<p>If you like the project and want to contribute:</p>
	<ul>
	<li>If you have IT skills, you can help with code development.</li>
	<li>If you have the language skills, help in translating the site.</li>
	<li>Alternatively, you could donate to support the development and cost of the site.</li>
	<ul>",
	"itIT" => "<p>Se ti piace il progetto e vuoi contribuire:</p>
	<ul>
	<li>Se hai le conoscenze informatiche, potresti aiutare nello sviluppo del codice.</li>
	<li>Se hai le conoscenze linguistiche, potresti aiutare nella traduzione del sito.</li>
	<li>In alternativa, potresti donare per supportare lo sviluppo e il costo del sito.</li>
	<ul>"
];


function render_all_tile()
{
	foreach ($GLOBALS["carddb"] as $value) {
		$hsrender_args["O"] = $GLOBALS["public_dir"] . "/" . $GLOBALS["tile_folder"] . "/" . $_COOKIE["lang"] . "/" . $value["id"] . ".png";
		$hsrender_args["J"] = $GLOBALS["carddb_file"];
		$hsrender_args["A"] = $GLOBALS["assets_dir"];
		$hsrender_args["L"] = $_COOKIE["lang"];
		$hsrender_args["D"] = $GLOBALS["assets_dir"] . $GLOBALS["art_folder"];
		$hsrender_args["I"] = true;
		$hsrender_args["i"] = $value['id'];

		$exec_command = $GLOBALS["hsrender_app"] . build_render_args($hsrender_args);
		$hsrender_app_output = "";

		exec($exec_command, $hsrender_app_result);
	}
}


function init()
{

	if (isset($_GET["L"]) && !empty($_GET["L"])) {
		$language = in_array($_GET["L"], $GLOBALS["languages"]) ? $_GET["L"] : $GLOBALS["default_lang"];
		setcookie("lang", $language, time() + $GLOBALS["cookie_expire"], $GLOBALS["cookie_location"]);
		$_COOKIE['lang'] = $language;
	} else if (!isset($_COOKIE["lang"]) || empty($_COOKIE["lang"])) {
		setcookie("lang", $GLOBALS["default_lang"], time() + $GLOBALS["cookie_expire"], $GLOBALS["cookie_location"]);
		$_COOKIE['lang'] = $GLOBALS["default_lang"];
	}


	if ($GLOBALS["init"] === true) {
		return;
	}

	if ($GLOBALS["debug"] === true) {
		error_reporting(E_ALL);
		ini_set('display_errors', true);
	}

	setlocale(LC_CTYPE, "en_US.UTF-8");

	if (!is_dir($GLOBALS["download_dir"])) {
		mkdir($GLOBALS["download_dir"]);
	}

	if (!is_dir($GLOBALS["public_dir"] . "/" . $GLOBALS["card_folder"])) {
		mkdir($GLOBALS["public_dir"] . "/" . $GLOBALS["card_folder"]);
	}
	foreach ($GLOBALS["languages"] as $language) {
		if (!is_dir($GLOBALS["public_dir"] . "/" . $GLOBALS["card_folder"] . "/" . $language)) {
			mkdir($GLOBALS["public_dir"] . "/" . $GLOBALS["card_folder"] . "/" . $language);
		}
	}

	if (!is_dir($GLOBALS["public_dir"] . "/" . $GLOBALS["tile_folder"])) {
		mkdir($GLOBALS["public_dir"] . "/" . $GLOBALS["tile_folder"]);
	}
	foreach ($GLOBALS["languages"] as $language) {
		if (!is_dir($GLOBALS["public_dir"] . "/" . $GLOBALS["tile_folder"] . "/" . $language)) {
			mkdir($GLOBALS["public_dir"] . "/" . $GLOBALS["tile_folder"] . "/" . $language);
		}
	}

	if (!is_dir($GLOBALS["public_dir"] . "/" . $GLOBALS["card_custom_folder"])) {
		mkdir($GLOBALS["public_dir"] . "/" . $GLOBALS["card_custom_folder"]);
	}

	if (!is_dir($GLOBALS["public_dir"] . "/" . $GLOBALS["tile_custom_folder"])) {
		mkdir($GLOBALS["public_dir"] . "/" . $GLOBALS["tile_custom_folder"]);
	}

	$GLOBALS["carddb"] = read_carddb($GLOBALS["carddb_file"]);

	if (isset($GLOBALS["render_all_tile"]) && $GLOBALS["render_all_tile"] === true) {
		render_all_tile();
	}

	$GLOBALS["init"] = true;
}