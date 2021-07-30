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

$card = NULL;
$type = "";
$query = "";

if (isset($_GET["i"]) && !empty($_GET["i"])) {
	$card = get_card_by_code($GLOBALS["carddb"], $_GET["i"]);
	if ($card === false) {
		die("Card \"" . $_GET["i"] . "\" does not exists!");
	}
	$type = $card["type"];
}

if (isset($_GET["y"]) && !empty($_GET["y"])) {
	if ($_GET["y"] === "TILE") {
		$type = "TILE";
	} else {
		$type = in_array($_GET["y"], $GLOBALS["card_type"]) ? $_GET["y"] : "";
	}
}

if (isset($_GET["query"])  && !empty($_GET["query"])) {
	$query = $_GET["query"];
}


?>
<!DOCTYPE html>
<html>

<head>
	<?php print_head("HSMeme.net | Card Builder"); ?>
</head>

<body>
	<?php print_header(); ?>
	<div class="container-fluid text-center">
		<div class="row content cardbuilder">
			<div class="col-sm-2 sidenav">
				<h3><?php echo _i18n($GLOBALS["titles_i18n"]["template_cards"]) ?></h3>
				<form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
					<input type="text" name="y" value="<?php echo $type; ?>" class="d-none">
					<div class="input-group">
						<input type="search" name="query" class="form-control form-control-dark"
							placeholder="Search..." aria-label="Search" maxlength="128"
							value="<?php echo $query; ?>">
						<button type="submit" class="btn btn-primary">
							<i class="fas fa-search"></i>
						</button>
					</div>
				</form>
				<ul class="list-group scrollable">
					<?php
					if (isset($_GET["query"]) && !empty($_GET["query"])) {
						$cardarray = search_card_array($GLOBALS["carddb"], $_GET["query"]);
						// TODO: Code replication in language list
						$url = get_current_url();
						$key = "i";
						$url = preg_replace('~(\?|&)' . $key . '=[^&]*~', '', $url);
						$url .= (parse_url($url, PHP_URL_QUERY) ? '&' : '?');
						foreach ($cardarray as $c) {
							$tile_file = "/" . $GLOBALS["tile_folder"] . "/" . $_COOKIE["lang"] . "/" . $c["id"] . ".png";
							if (file_exists($GLOBALS["public_dir"] . '/' . $tile_file)) {
								echo '<li class="list-group-item card-list-item"><a href="' . $url . 'i=' . $c["id"] . '"><img src="' . $tile_file . '" alt=' . $c["name"][$_COOKIE["lang"]] . '/></a></li>';
							} else {
								echo '<li class="list-group-item"><a href="' . $url . 'i=' . $c["id"] . '">' . $c["name"][$_COOKIE["lang"]] . '</a></li>';
							}
						}
					}
					?>
				</ul>
			</div>
			<div class="col-sm-8 text-left mainbox">
				<h1><?php echo _i18n($GLOBALS["titles_i18n"]["card_builder"]) ?></h1>
				<?php print_tabs_page('/cardbuilder.php', 'y', $type, $GLOBALS["card_type_i18n"]); ?>
				<form action="/render.php" method="post" enctype="multipart/form-data">
					<?php
					if ($card !== NULL) {
						$form_values = card2args($card);
					}
					if (!empty($type)) {
						$form_values["y"] = $type;
					}

					if (!empty($form_values['y'])) {
						$form_exclude = array();
						if ($form_values['y'] === 'MINION') {
							$form_exclude = ['m', 'd', 'S'];
						} else if ($form_values['y'] === 'SPELL') {
							$form_exclude = ['a', 'H', 'm', 'd', 'R'];
						} else if ($form_values['y'] === 'WEAPON') {
							$form_exclude = ['H', 'm', 'R', 'S'];
						} else if ($form_values['y'] === 'HERO') {
							$form_exclude = ['a', 'H', 'd', 'R', 'S'];
						} else if ($form_values['y'] === 'HERO_POWER') {
							$form_exclude = ['a', 'H', 'd', 'R', 'S', 'C', 'm', 'r', 's'];
						} else if ($form_values['y'] === 'TILE') {
							$form_exclude = ['a', 'H', 'd', 'R', 'S', 'm', 's', 't'];
						}
						print_form_input($GLOBALS["form_input_i18n"], $_COOKIE["lang"], $form_values, $form_exclude);
					}
					?>
				</form>
			</div>
			<div class="col-sm-2 sidenav">
				<?php print_about(); ?>
			</div>
		</div>
	</div>
	<?php print_footer(); ?>

</body>

</html>