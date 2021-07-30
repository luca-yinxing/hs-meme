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

$query = "";
$title_i18n = ["enUS" => "Hearthstone Meme"];
$hscards_title_i18n = ["enUS" => "Hearthstone Cards", "itIT" => "Carte di Hearthstone"];

$main_title_i18n = ["enUS" => "Card Builder and Meme", "itIT" => "Costruttore di Carte e Meme"];
$main_text_i18n = [
	"enUS" => "The world of Hearthstone cards is very diverse, so why not allow users to create new card concepts, or share memes in the community?<br>
	This site aims to give efficient and powerful tools to the community of Hearthstone fans to generate any type of card.",
	"itIT" => "Il mondo delle carte di Hearthstone è molto vario, quindi perchè non permettere agli utenti di creare nuovi concept per le carte, oppure condividere meme nella comunità?<br>
	Questo sito vuole dare degli strumenti efficienti e potenti alla comunità di appassionati di Hearthstone per generare qualsiasi tipo di carta."
];

$tech_title_i18n = ["enUS" => "Rendering Tecnology", "itIT" => "Tecnologia di Rendering"];
$tech_text_i18n = [
	"enUS" => "To generate the cards, a program has been developed that, given the card details, provides an image as if it were in the Hearthstone client.<br>
	This program is a part of the Hearthstone tools development, if you want to help the project, please go to the \"How to Contribute\" section.",
	"itIT" => "Per generare le carte, è stato sviluppato un programma che, dati i dettagli della carta, fornisce un immagine come se fosse nel client di Hearthstone.
	Più in generale il processo di creazione di una immagine è chiamato Rendering.<br>
	Questo programma è una parte dello sviluppo degli strumenti di Hearthstone, se vuoi aiutare il progetto, passa nella sezione \"Come Contribuire\"."
];

$api_title_i18n = ["enUS" => "Rendering API"];
$api_text_i18n = [
	"enUS" => "You can freely use the API, you can even if you have a high traffic site, consider re-hosting the backend directly.
	This site's APIs can be accessed through the <mark>/render.php</mark> endpoint. <br>
	Below you will find a list of the parameters for <mark>POST</mark> and <mark>GET</mark> methods.",
	"itIT" => "Puoi usare liberamente le API, tuttavia se possiedi un sito ad alto traffico, considera di ri-hostare direttamente il backend.
	È possibile accedere alle API di questo sito tramite l'endpoint <mark>/render.php</mark>.<br>
	Di seguito troverai una lista dei parametri per i metodi <mark>POST</mark> e <mark>GET</mark>."
];

$api_table_head_i18n[] = ["enUS" => "Property", "itIT" => "Proprietà"];
$api_table_head_i18n[] = ["enUS" => "Key", "itIT" => "Chiave"];
$api_table_head_i18n[] = ["enUS" => "Type", "itIT" => "Tipo"];
$api_table_head_i18n[] = ["enUS" => "Values", "itIT" => "Valori"];

$bug_title_i18n = ["enUS" => "Known Bugs", "itIT" => "Problemi Conosciuti"];
$bug_pre_i18n = [
	"enUS" => "Below you will find a list of bugs already reported, if you have encountered a bug not present here, go to the \"Contacts \" section:",
	"itIT" => "Di seguito troverai una lista di problemi già segnalati, se hai incontrato un problema non presente qui, passa nella sezione \"Contatti\":"
];
$bug_text_i18n[] = [
	"enUS" => "It is not possible to remove the race or spellschool from a card template that has it.",
	"itIT" => "Non è possibile togliere la razza o la scuola di magia ad un modello di carta che la possiede."
];
$bug_text_i18n[] = [
	"enUS" => "The race and spellschool are rendered differently than the official Hearthstone cards.",
	"itIT" => "La razza e la scuola di magia vengono renderizzate in modo differente rispetto carte ufficiali di Hearthstone."
];
$bug_text_i18n[] = [
	"enUS" => "The rarity of hero cards is rendered differently than official Hearthstone cards.",
	"itIT" => "La rarità delle carte eroe viene renderizzata in modo differente rispetto carte ufficiali di Hearthstone."
];
$bug_text_i18n[] = [
	"enUS" => "Hearthstone's official dual-class cards are rendered with a single class.",
	"itIT" => "Le carte bi-classe ufficiali di Hearthstone vengono renderizzate con una singola classe."
];

$milestone_title_i18n = ["enUS" => "Milestone"];
$milestone_pre_i18n = [
	"enUS" => "Below you will find a list of objectives, if you want to help the project, go to the \"How to Contribute\" section:",
	"itIT" => "Di seguito troverai una lista di obiettivi, se vuoi aiutare il progetto, passa nella sezione \"Come Contribuire\":"
];
$milestone_text_i18n[] = [
	"enUS" => "Add translations for other languages ​​besides Italian and English.",
	"itIT" => "Aggiungere le traduzioni per altre lingue, oltre l'Italiano e l'Inglese."
];
$milestone_text_i18n[] = [
	"enUS" => "Add the ability for the user to select a dark theme for the site.",
	"itIT" => "Aggiungere la possibilità per l'utente di selezionare un tema scuro per il sito."
];
$milestone_text_i18n[] = [
	"enUS" => "Add users with the ability to log in.",
	"itIT" => "Aggiungere gli utenti con possibilità di effettuare un accesso."
];
$milestone_text_i18n[] = [
	"enUS" => "Add automatic language detection of users.",
	"itIT" => "Aggiungere la rilevazione automatica della lingua degli utenti."
];
$milestone_text_i18n[] = [
	"enUS" => "Add a guide to using the rendering API.",
	"itIT" => "Aggiungere una guida all'utilizzo delle API di rendering."
];
$milestone_text_i18n[] = [
	"enUS" => "Integrate the backend to remove the second reading of the card database by PHP.",
	"itIT" => "Intergrare il backend in modo da rimuovere la seconda lettura del database delle carte da parte del PHP."
];
$milestone_text_i18n[] = [
	"enUS" => "If possible, optimize the rendering times of the backend.",
	"itIT" => "Ottimizzare, se possibile, i tempi di rendering del backend."
];
$milestone_text_i18n[] = [
	"enUS" => "Save custom cards to a database and provide a permanent URL.",
	"itIT" => "Salvare in un database le carte personalizzate e fornire un URL permanente."
];
$milestone_text_i18n[] = [
	"enUS" => "Add the ability to change fonts in the rendering stage.",
	"itIT" => "Aggiungere la possibilità di modificare i font nella fase di rendering."
];
$milestone_text_i18n[] = [
	"enUS" => "Add the ability to create dual-class cards.",
	"itIT" => "Aggiungere la possibilità di creare carte bi-classe."
];
$milestone_text_i18n[] = [
	"enUS" => "Add the ability to create dual-class tile.",
	"itIT" => "Aggiungere la possibilità di creare miniature bi-classe."
];
$milestone_text_i18n[] = [
	"enUS" => "Add the ability to choose which (and how) elements to render in the tile.",
	"itIT" => "Aggiungere la possibilità di scegliere quali (e come) elementi renderizzare nella tile."
];


if (isset($_GET["query"])  && !empty($_GET["query"])) {
	$query = $_GET["query"];
}
?>

<!DOCTYPE html>
<html>

<head>
	<?php print_head("HSMeme.net"); ?>
</head>

<body>
	<?php print_header(); ?>
	<div class="container-fluid">
		<div class="row content">
			<div class="col-sm-2 sidenav text-center">
				<h3><?php echo _i18n($hscards_title_i18n); ?></h3>
				<?php print_hscards($query, "/render.php"); ?>
			</div>
			<div class="col-sm-8 text-left mainbox">
				<h1 class="text-center"><?php echo _i18n($title_i18n); ?></h1>
				<h3><?php echo _i18n($main_title_i18n); ?></h3>
				<p><?php echo _i18n($main_text_i18n); ?></p>
				<h3><?php echo _i18n($tech_title_i18n); ?></h3>
				<p><?php echo _i18n($tech_text_i18n); ?></p>
				<h3><?php echo _i18n($api_title_i18n); ?></h3>
				<p><?php echo _i18n($api_text_i18n); ?></p>
				<table class="table">
					<thead>
						<tr>
							<?php
							foreach ($api_table_head_i18n as $table_head) {
								echo '<th scope="col">' . _i18n($table_head) . '</th>';
							}
							?>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($GLOBALS["form_input_i18n"] as $key => $value) {
							if ($value["type"] === "button") {
								continue;
							}

							echo '<tr>';
							echo '<td>' . substr(_i18n($value), 0, -1) . '</td>';
							echo '<td>' . $key . '</td>';
							echo '<td>' . $value["type"] . '</td>';
							$print_values_list = "";
							if ($value["type"] === "select" && isset($value["values"]) && !empty($value["values"])) {
								foreach ($value["values"] as $v) {
									if (!empty($v)) {
										$print_values_list .= $v . " / ";
									}
								}
								$print_values_list = substr($print_values_list, 0, -3);
							}
							echo '<td class="api_table_values">' . $print_values_list . '</td>';
							echo '</tr>';
						}
						?>
					</tbody>
				</table>
				<h3><?php echo _i18n($bug_title_i18n); ?></h3>
				<p><?php echo _i18n($bug_pre_i18n); ?></p>
				<ul>
					<?php
					foreach ($bug_text_i18n as $text) {
						echo '<li>';
						echo _i18n($text);
						echo '</li>';
					}
					?>
				</ul>
				<h3><?php echo _i18n($milestone_title_i18n); ?></h3>
				<p><?php echo _i18n($milestone_pre_i18n); ?></p>
				<ul>
					<?php
					foreach ($milestone_text_i18n as $text) {
						echo '<li>';
						echo _i18n($text);
						echo '</li>';
					}
					?>
				</ul>
			</div>
			<div class="col-sm-2 sidenav text-center">
				<?php print_about(); ?>
			</div>
		</div>
	</div>
	<?php print_footer(); ?>

</body>

</html>