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

require "data.php";
include "utils.php";

init();

$input = array();
$input_art = NULL;
$delete_file = true;

if (!empty($_GET)) {
	$input = $_GET;
} else if (!empty($_POST)) {
	$input = $_POST;
}

if (empty($input)) {
	die("Error: No parameters!");
}

if (isset($_FILES["art"]["tmp_name"]) && !empty($_FILES["art"]["tmp_name"])) {

	$input_art = $_FILES["art"]["tmp_name"];

	$check = getimagesize($input_art);
	if ($check === false) {
		die("File is not an image.");
	}
}

if (isset($input["i"]) && !empty($input["i"])) {
	$card = get_card_by_code($GLOBALS["carddb"], $input["i"]);
	if ($card === false) {
		die("Card \"" . $input["i"] . "\" does not exists!");
	}
	$hsrender_args["i"] = $card["id"];
}
if ($input_art !== NULL && !empty($input_art)) {
	$hsrender_args["T"] = $input_art;
}
$hsrender_args["J"] = $GLOBALS["carddb_file"];
$hsrender_args["A"] = $GLOBALS["assets_dir"];
$hsrender_args["L"] = $_COOKIE["lang"];
$hsrender_args["D"] = $GLOBALS["assets_dir"] . $GLOBALS["art_folder"];
$hsrender_args["n"] = isset($input["n"]) && strlen($input["n"]) <= $GLOBALS["max_strlen"] ? $input["n"] : "";
$hsrender_args["t"] = isset($input["t"]) && strlen($input["t"]) <= $GLOBALS["max_strlen"] ? $input["t"] : "";
$hsrender_args["a"] = isset($input["a"]) && is_numeric($input["a"]) ? $input["a"] : "";
$hsrender_args["H"] = isset($input["H"]) && is_numeric($input["H"]) ? $input["H"] : "";
$hsrender_args["c"] = isset($input["c"]) && is_numeric($input["c"]) ? $input["c"] : "";
$hsrender_args["m"] = isset($input["m"]) && is_numeric($input["m"]) ? $input["m"] : "";
$hsrender_args["d"] = isset($input["d"]) && is_numeric($input["d"]) ? $input["d"] : "";
if (isset($input["y"]) && $input["y"] === "TILE") {
	$hsrender_args["I"] = true;
} else {
	$hsrender_args["y"] = isset($input["y"]) && in_array($input["y"], $GLOBALS["card_type"]) ? $input["y"] : "";
}
$hsrender_args["s"] = isset($input["s"]) && in_array($input["s"], $GLOBALS["card_set"]) ? $input["s"] : "";
$hsrender_args["R"] = isset($input["R"]) && in_array($input["R"], $GLOBALS["card_race"]) ? $input["R"] : "";
$hsrender_args["r"] = isset($input["r"]) && in_array($input["r"], $GLOBALS["card_rarity"]) ? $input["r"] : "";
$hsrender_args["S"] = isset($input["S"]) && in_array($input["S"], $GLOBALS["card_spellschool"]) ? $input["S"] : "";
$hsrender_args["C"] = isset($input["C"]) && in_array($input["C"], $GLOBALS["card_class"]) ? $input["C"] : "";

if (
	(count($input) === 1 && isset($input["i"]) && !empty($input["i"])) ||
	(!isset($hsrender_args["T"]) && is_original_card($hsrender_args, $card))
) {
	if (isset($hsrender_args["I"]) && !empty($hsrender_args["I"])) {
		$output_folder = $GLOBALS["tile_folder"];
	} else {
		$output_folder = $GLOBALS["card_folder"];
	}
	if (isset($card["id"]) && !empty($card["id"])) {
		$hsrender_args["O"] = $GLOBALS["public_dir"] . "/" . $output_folder . "/" . $_COOKIE["lang"] . "/" . $card["id"] . ".png";
		$filename = $_COOKIE["lang"] . "_" . $card["id"] . ".png";
		$delete_file = false;
	} else {
		die("Invalid Arguments");
	}
} else {
	if (isset($hsrender_args["I"]) && !empty($hsrender_args["I"])) {
		$output_folder = $GLOBALS["tile_custom_folder"];
	} else {
		$output_folder = $GLOBALS["card_custom_folder"];
	}
	$filename = uniqid() . ".png";
	$hsrender_args["O"] = $GLOBALS["public_dir"] . "/" . $output_folder . "/" . $filename;
}

if (!file_exists($hsrender_args["O"])) {
	$exec_command = $GLOBALS["hsrender_app"] . build_render_args($hsrender_args);
	$hsrender_app_output = "";

	exec($exec_command, $hsrender_app_result);
}


if (isset($hsrender_args["O"]) && !empty($hsrender_args["O"])) {
	$output_file_fd = fopen($hsrender_args["O"], "r") or die("Unable to open file!");
	$output_file_size = filesize($hsrender_args["O"]);
	$output_file_pixmap = fread($output_file_fd, $output_file_size);

	header('Content-type: image/png');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . $output_file_size);
	header('Content-Disposition: filename="' . $filename . '"');

	echo $output_file_pixmap;

	fclose($output_file_fd);
	if ($delete_file) {
		unlink($hsrender_args["O"]);
	}
	die();
}