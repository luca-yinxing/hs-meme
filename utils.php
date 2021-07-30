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

function get_current_url()
{
	$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	return $current_url;
}

function rebuild_url($pageurl, $get, $array)
{
	$merge = array_merge($get, $array);
	if (empty($merge)) {
		return $pageurl;
	}

	$url = $pageurl . "?";
	foreach ($merge as $key => $value) {
		$url .= $key . "=" . $value . "&";
	}
	$url = substr($url, 0, -1);

	return $url;
}

function hs2html($text)
{
	$retval = $text;
	$retval = str_replace("\n", "<br>", $retval);
	$retval = str_replace("[x]", "", $retval);
	$retval = str_replace("$", "", $retval);

	return $retval;
}

function read_carddb($jsonfile)
{
	if (!file_exists($jsonfile)) {
		die("Json carddb does not exists!");
	}
	$fd = fopen($jsonfile, "r") or die("Unable to open file!");
	$size = filesize($jsonfile);
	$data = fread($fd, $size);
	fclose($fd);

	$result = json_decode($data, true);
	return $result;
}

function card2args($card)
{
	$args["i"] = isset($card["id"]) ? $card["id"] : "";
	$args["y"] = isset($card["type"]) ? $card["type"] : "";
	$args["n"] = isset($card["name"][$_COOKIE["lang"]]) ? $card["name"][$_COOKIE["lang"]] : "";
	$args["t"] = isset($card["text"][$_COOKIE["lang"]]) ? hs2html($card["text"][$_COOKIE["lang"]]) : "";
	$args["a"] = isset($card["attack"]) ? (string)$card["attack"] : "";
	$args["H"] = isset($card["health"]) ? (string)$card["health"] : "";
	$args["c"] = isset($card["cost"]) ? (string)$card["cost"] : "";
	$args["m"] = isset($card["armor"]) ? (string)$card["armor"] : "";
	$args["d"] = isset($card["durability"]) ? (string)$card["durability"] : "";
	$args["s"] = isset($card["set"]) ? $card["set"] : "";
	$args["R"] = isset($card["race"]) ? $card["race"] : "";
	$args["r"] = isset($card["rarity"]) ? $card["rarity"] : "";
	$args["S"] = isset($card["spellSchool"]) ? $card["spellSchool"] : "";
	$args["C"] = isset($card["cardClass"]) ? $card["cardClass"] : "";

	return $args;
}

function is_original_card($args, $card)
{
	$fields = array();
	if (isset($args["I"]) && $args["I"] === true) {
		$fields = ["n", "c", "r", "C"];
	} else if ($args["y"] === "HERO") {
		$fields = ["y", "n", "t", "c", "m", "s", "r", "C"];
	} else if ($args["y"] === "MINION") {
		$fields = ["y", "n", "t", "c", "a", "H", "s", "r", "R", "C"];
	} else if ($args["y"] === "SPELL") {
		$fields = ["y", "n", "t", "c", "s", "r", "S", "C"];
	} else if ($args["y"] === "WEAPON") {
		$fields = ["y", "n", "t", "c", "a", "d", "s", "r", "C"];
	} else if ($args["y"] === "HERO_POWER") {
		$fields = ["y", "n", "t", "c"];
	} else {
		die("Error: Undefined type of card!");
	}
	$cmp = card2args($card);
	foreach ($cmp as $key => $value) {
		if (!in_array($key, $fields)) {
			continue;
		}
		if (!isset($args[$key]) || $args[$key] !== $value) {
			return false;
		}
	}

	return true;
}

function get_card_by_code($carddb, $code)
{
	foreach ($carddb as $card) {
		if ($code === $card["id"]) {
			return $card;
		}
	}
	return false;
}

function search_card_array($carddb, $text)
{
	$result = array();
	if (empty($text)) {
		return $result;
	}

	$text = strtolower($text);

	foreach ($carddb as $card) {
		if ($text === strtolower($card["id"])) {
			$result[] = $card;
		}
		if (strpos(strtolower($card["name"][$_COOKIE["lang"]]), $text) !== false) {
			$result[] = $card;
		}
	}
	return $result;
}


function build_render_args($array)
{
	$result = "";
	foreach ($array as $key => $value) {
		if (!empty($value)) {
			$result .= " -" . $key . " " . escapeshellarg($value);
		}
	}
	return $result;
}

function array_keys_are_empty($array, $keys)
{
	foreach ($array as $key => $value) {
		if (in_array($key, $keys)) {
			if (!empty($value)) {
				return false;
			}
		}
	}
	return true;
}

function _i18n($value)
{
	return isset($value[$_COOKIE["lang"]]) ? $value[$_COOKIE["lang"]] : $value[$GLOBALS["default_lang"]];
}

function print_header()
{
	echo '
	<nav class="navbar navbar navbar-dark bg-dark justify-content-between">
	<div class="container">';

	echo '<a href="/"
				class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
				<svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
					<use xlink:href="#bootstrap"></use>
				</svg>
			</a>';
	$url = $_SERVER["REQUEST_URI"];

	echo '<ul class="nav col-lg-auto me-lg-auto mb-2 mb-md-0">';
	foreach ($GLOBALS["navbar_i18n"] as $key => $value) {
		if (preg_match('/^\\' . $key . '$|\\' . $key . '\?/', $_SERVER["REQUEST_URI"])) {
			echo '<li><a href="' . $key . '" class="nav-link px-2 text-secondary">' . _i18n($value) . '</a></li>';
		} else {
			echo '<li><a href="' . $key . '" class="nav-link px-2 text-white">' . _i18n($value) . '</a></li>';
		}
	}
	echo '</ul>';

	echo '<form class="d-flex my-2 my-lg-0">';

	//echo '<i class="flag-icon flag-icon-'.substr($_COOKIE["lang"],0,2).'"></i>';
	echo '<select id="L" name="L" class="form-control mr-sm-2"><div class="input-group">';
	foreach ($GLOBALS["languages_i18n"] as $key => $value) {
		if ($key === $_COOKIE["lang"]) {
			echo '<option value="' . $key . '" selected>' . _i18n($value) . '</option>';
		} else {
			echo '<option value="' . $key . '">' . _i18n($value) . '</option>';
		}
	}
	echo '</select>';
	echo '<button type="submit" class="btn btn-primary my-2 my-sm-0"><i class="fa fa-reply"></i></button>';
	echo '</div></form>';
	echo '</div>
	</nav>';
}

function print_footer()
{
	echo '<footer class="container-fluid text-center">
		<p>HSMeme.net | Luca Gasperini | 2021</p>
	</footer>';
}

function print_head($title)
{
	echo '<title>' . $title . '</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/style.css">
	<link href="/fontawesome/css/all.css" rel="stylesheet">
	<script src="/bootstrap/js/bootstrap.bundle.min.js"></script>';
}

function print_tabs_page($pageurl, $param, $current_value, $array)
{
	echo '<ul class="nav nav-tabs">';

	foreach ($array as $key => $value) {
		if (isset($current_value) && $current_value === $key) {
			$a_class = 'class="nav-link active"';
		} else {
			$a_class = 'class="nav-link"';
		}
		echo '<li class="nav-item"><a ' . $a_class . ' href="' . rebuild_url($pageurl, $_GET, [$param => $key]) . '">' . _i18n($value) . '</a></li>';
	}
	echo '</ul>';
}

function print_form_row_input_text($name, $label, $class = "", $value = "", $readonly = false)
{
	$str_readonly = "";
	$str_value = "";
	if ($readonly === true) {
		$str_readonly = "readonly";
	}
	if (!empty($value)) {
		$str_value = 'value="' . $value . '"';
	}
	$id = 'input_' . $name;
	echo '<div class="' . $class . ' form-group row">';
	if (!empty($label)) {
		echo '<label for="' . $id . '" class="col-sm-2 col-form-label">' . $label . '</label>';
	}
	echo '<div class="col-sm-10">';
	echo '<input type="text" ' . $str_readonly . ' name="' . $name . '" class="form-control" id="' . $id . '" ' . $str_value . '>';
	echo '</div></div>';
}

function print_form_row_input_textarea($name, $label, $class = "", $value = "", $readonly = false)
{
	$str_readonly = "";
	if ($readonly === true) {
		$str_readonly = "readonly";
	}
	$id = 'input_' . $name;
	echo '<div class="' . $class . ' form-group row">';
	if (!empty($label)) {
		echo '<label for="' . $id . '" class="col-sm-2 col-form-label">' . $label . '</label>';
	}
	echo '<div class="col-sm-10">';
	echo '<textarea ' . $str_readonly . ' class="form-control" name="' . $name . '" id="' . $id . '">' . $value . '</textarea>';
	echo '</div></div>';
}

function print_form_row_input_number($name, $label, $class = "", $value = "", $min = "", $max = "", $readonly = false)
{
	$str_value = "";
	$str_readonly = "";
	$str_min = "";
	$str_max = "";
	if ($readonly === true) {
		$str_readonly = "readonly";
	}
	if (!empty($value)) {
		$str_value = 'value="' . $value . '"';
	}
	if (!empty($min) || $min === "0") {
		$str_min = 'min="' . $min . '"';
	}
	if (!empty($max) || $max === "0") {
		$str_max = 'max="' . $max . '"';
	}
	$id = 'input_' . $name;
	echo '<div class="' . $class . ' form-group row">';
	if (!empty($label)) {
		echo '<label for="' . $id . '" class="col-sm-2 col-form-label">' . $label . '</label>';
	}
	echo '<div class="col-sm-10">';
	echo '<input  type="number" ' . $str_readonly . ' name="' . $name . '" class="form-control" id="' . $id . '"' . $str_value . ' ' . $str_min . ' ' . $str_max . '>';
	echo '</div></div>';
}

function print_form_row_input_file($name, $label, $class = "", $accept = "")
{
	$str_accept = "";
	if (!empty($accept)) {
		$str_accept = 'accept="' . $accept . '"';
	}
	$id = 'input_' . $name;
	echo '<div class="' . $class . ' form-group row">';
	if (!empty($label)) {
		echo '<label for="' . $id . '" class="col-sm-2 col-form-label">' . $label . '</label>';
	}
	echo '<div class="col-sm-10">';
	echo '<input type="file" name="' . $name . '" class="form-control" id="' . $id . '" ' . $str_accept . '>';
	echo '</div></div>';
}

function print_form_row_input_select($name, $label, $class = "", $value = "", $values = array())
{
	$id = 'input_' . $name;

	echo '<div class="' . $class . ' form-group row">';
	if (!empty($label)) {
		echo '<label for="' . $id . '" class="col-sm-2 col-form-label">' . $label . '</label>';
	}
	echo '<div class="col-sm-10"><select id="' . $id . '" name="' . $name . '" class="form-control">';
	foreach ($values as $item) {
		if ($item === $value) {
			echo '<option selected>' . $item . '</option>';
		} else {
			echo '<option>' . $item . '</option>';
		}
	}
	echo '</select></div>';
	echo '</div>';
}

function print_form_row_input_button($name, $text)
{
	echo '<div class="form-group">';
	echo '<button type="submit" name="' . $name . '" class="btn btn-primary">' . $text . '</button>';
	echo '</div>';
}

function print_form_input($fields, $lang, $values = array(), $exclude = array())
{
	$label_text = "";

	foreach ($fields as $key => $value) {
		if (in_array($key, $exclude)) {
			continue;
		}
		if (isset($value[$lang])) {
			$label_text = $value[$lang];
		} else {
			$label_text = $value[$GLOBALS["default_lang"]];
		}
		if ($value["type"] === "text") {
			print_form_row_input_text(
				$key,
				$label_text,
				isset($value['class']) ? $value['class'] : "",
				isset($values[$key]) ? $values[$key] : "",
				isset($value['readonly']) ? $value['readonly'] : false
			);
		} else if ($value["type"] === "number") {
			print_form_row_input_number(
				$key,
				$label_text,
				isset($value['class']) ? $value['class'] : "",
				isset($values[$key]) ? $values[$key] : "",
				isset($value['min']) ? $value['min'] : "",
				isset($value['max']) ? $value['max'] : "",
				isset($value['readonly']) ? $value['readonly'] : false
			);
		} else if ($value["type"] === "file") {
			print_form_row_input_file(
				$key,
				$label_text,
				isset($value['class']) ? $value['class'] : "",
				isset($value['accept']) ? $value['accept'] : ""
			);
		} else if ($value["type"] === "select") {
			print_form_row_input_select(
				$key,
				$label_text,
				isset($value['class']) ? $value['class'] : "",
				isset($values[$key]) ? $values[$key] : "",
				isset($value['values']) ? $value['values'] : array()
			);
		} else if ($value["type"] === "textarea") {
			print_form_row_input_textarea(
				$key,
				$label_text,
				isset($value['class']) ? $value['class'] : "",
				isset($values[$key]) ? $values[$key] : "",
				isset($value['readonly']) ? $value['readonly'] : false
			);
		} else if ($value["type"] === "button") {
			print_form_row_input_button($key, $label_text);
		}
	}
}

function print_hscards($query, $targeturl)
{
	echo '<form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">';
	echo '<div class="input-group">';
	echo '<input type="search" name="query" class="form-control form-control-dark" placeholder="Search..." aria-label="Search" maxlength="128"';
	if (!empty($query)) {
		echo 'value="' . $query . '"';
	}
	echo '>';
	echo '<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>';
	echo '</div>';
	echo '</form>';

	echo '<ul class="list-group scrollable">';

	if (!empty($query)) {
		$cardarray = search_card_array($GLOBALS["carddb"], $query);
		foreach ($cardarray as $c) {
			$url = $targeturl . "?i=" . $c["id"];
			$tile_file = "/" . $GLOBALS["tile_folder"] . "/" . $_COOKIE["lang"] . "/" . $c["id"] . ".png";
			if (file_exists($GLOBALS["public_dir"] . '/' . $tile_file)) {
				echo '<li class="list-group-item card-list-item"><a href="' . $url . '"><img src="' . $tile_file . '" alt=' . $c["name"][$_COOKIE["lang"]] . '/></a></li>';
			} else {
				echo '<li class="list-group-item"><a href="' . $url . '">' . $c["name"][$_COOKIE["lang"]] . '</a></li>';
			}
		}
	}
	echo '</ul>';
}

function print_donate()
{
	echo '<form action="https://www.paypal.com/donate" method="post" target="_top">
		<input type="hidden" name="hosted_button_id" value="7Q8UDX6EBZZ3G" />
		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
		<img alt="" border="0" src="https://www.paypal.com/en_IT/i/scr/pixel.gif" width="1" height="1" />
		</form>';
}

function print_about()
{
	echo '<h3>' . _i18n($GLOBALS["about_contact_title_i18n"]) . '</h3>';
	echo '<div class="contact">';
	echo _i18n($GLOBALS["about_contact_i18n"]);
	echo '<a href="https://gitlab.com/EnigmaXS" class="fa_social fab fa-gitlab"></a>';
	echo '<a href="https://twitter.com/LucaGasperini_" class="fa_social fab fa-twitter"></a>';
	echo '<a href="https://www.twitch.tv/enigmaxs" class="fa_social fab fa-twitch"></a>';
	echo '<a href="mailto:info@xsoftware.it" class="fa_social fas fa-envelope"></a>';
	echo "</div>";
	echo '<h3>' . _i18n($GLOBALS["about_contrib_title_i18n"]) . '</h3>';
	echo '<div class="contrib">' . _i18n($GLOBALS["about_contrib_i18n"]) . "</div>";
	print_donate();
}