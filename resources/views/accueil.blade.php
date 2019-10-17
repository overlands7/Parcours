<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<title>Parcours</title>
	<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
<style type="text/css">
	html, body {
		background-color: grey; 
		font-size: 25px;
		font-family: 'Arial Narrow', sans-serif;
	}
	.titre_parcours {
		text-align: center; 	
	}
	.texte_parcours {
		text-align: center;
	}
	.input{
		text-align: center;
	}
	.parcours_button{
		text-align: center;
	}
	.parcours_explication{
		text-align: center;
	}
	.Menu{
		text-align: center;
	}
	.question_style{
		text-align: center;
	}
	.question_liste_style{
		text-align: center;
	}
	.reponse_style{
		text-align: center;
	}
	li{
		list-style-type: none;
	}
</style>

<script type="text/javascript">
//FB5B45
	//var URL = {!! json_encode(url('/')) !!};
	var testp = JSON.parse({!! json_encode($reponse) !!});
	var currentParcoursId = 0;
	var currentQuestion;
	var currentParcours;
	var questionsHistory = [];
	var affiche = false;

	$(document).ready(function() {
		console.log("s");
		showParcours();

		//$.getJSON("test1.json", function(data)
		//{
		//	console.log("Normalement ça marche");
		//});
	});

	function listeparcours(){
		return testp.parcours;
	}

	function getquestionid(questionrecup) {
		return testp.questions[questionrecup];
	}

	function showParcours() {
			var affiche = false;
		if(affiche == false) {
			$('#question_liste').empty();
			$('#retour_question').empty();
			$('reponse').empty();
			var useparcours = listeparcours();
			affiche = true;
			for(var recup = 0; recup<useparcours.length; recup++)
			{
				$('#parcours_button').append('<input type="submit" style=" width:130px; height:30px" value ="' + useparcours[recup].titre + '" onclick="intermediaire(' + recup + ')" />');
				$('#parcours_liste').append( '<li><a href="#" onclick="intermediaire(' + recup + ');">' + useparcours[recup].titre + '</a></li>' );

			}
		}
		$('#parcours').show();
		$('#parcours_explication').hide();
		$('#menu_bouton').hide();
	}

	function startParcours(parcoursId) {
		showQuestion(parcoursId);
	}

	function showQuestion(newQuestion) {

		if(currentQuestion != null)
			questionsHistory.push(currentQuestion);
		currentQuestion = getquestionid(newQuestion);

		$('#reponse').empty();
		$('#retour_question').empty();
		$('#question').show();
		$('#questionsname').empty();
		$('#question_liste').show();
		$('#menu').show();
		$('#definition').hide();
		$('#demarer').hide();
		$('#question_liste').empty();

		if(typeof currentQuestion.label != 'undefined' || currentQuestion.label !=null ){

		$('#questionsname').append(currentQuestion.label);
		if(newQuestion != 0){
			$('#retour_question').show();
			$('#retour_question').append('<input type="submit" style=" width:130px; height:30px" id="retour" onclick="retour('+ currentQuestion.qid +');" value="Retour" /><br/>');

		}
		
		for(var index = 0; index<currentQuestion.answers.length; index++)
		{
			var reponseQ= "'"+ currentQuestion.answers[index].textereponse+ "'";
			$('#question_liste').append('<li><input type="submit" style=" width:130px; height:30px" value="' + currentQuestion.answers[index].name + '" onclick="showreponse(' + currentQuestion.answers[index].suite + ', ' + reponseQ + ',' + currentQuestion.answers[index].question_id + ')"/></li>');
		}

	}else{
		$('#question').append('<p>Le paroucours est fini. <a href="#" onClick="window.location.reload()">  Retour à la home</a></p>');

	}	

	}

	function showreponse(reponse, reponsetexte, id_question){
		console.log(reponse);
		$('#question_liste').hide();
		if(reponse == true) {
			showQuestion(id_question);
		}else{
			$('#reponse').show();
			$('#reponse').append('<p>' + reponsetexte + '</p>' + '<input type="submit" style=" width:130px; height:30px" value="suivant" onclick="showQuestion(' + id_question + ')"/>');
		}
	}

	function intermediaire(parcoursId) {
		var inter = listeparcours();
		$('.label').text(inter[parcoursId].titre);
		$('#definition').text(inter[parcoursId].definition);
		$('#demarer').attr('onclick', "startParcours( " + parcoursId + ")");
		$('#parcours_explication').show();
		$('#parcours').hide();
		$('#menu_bouton').show();

	}

	function retour(retour) {
		var retourquestion = retour-1;
		showQuestion(retourquestion);

	}

	function restartparcours() {
		startParcours(0);
	}

</script>

<div id="parcours">

	<h1 class ="titre_parcours">Liste des parcours</h1>

	<a href=""></a>
	<a href=""></a>
	<a href=""></a>
	<p class ="texte_parcours">texte explicatif des parcours </p>

	<div id="parcours_button" class="parcours_button">
	</div>

</div>

<div id="parcours_explication" style="display:none" class="parcours_explication">

	<h1 class="label"></h1>

	<p id="definition"></p>

	<input type="submit" name="demarer" id="demarer" value="Demarer" style=" width:130px; height:30px"/>
</div>

<div id="menu_bouton" style="display:none">

	<input type="submit" id ="menu_click" onclick="	$('#menu_global').show();" value="Menu" style=" width:130px; height:30px;" />

		<div id="menu_global" style="display:none" class="menu_global">

			<ul id="parcours_liste">
		
			<a href="#"  onClick="window.location.reload();">Accueil</a><br>
			<input type="submit" id="restart" onclick="restartparcours();" value="Relancer parcours" style=" width:160px; height:40px"/><br/>
		
		</ul>
	
	</div>
</div>

<div id="retour_question" style="display:none">	
</div>


<div id="question" style="display:none" class="question_style">
	<p id="questionsname"></p>
	<ul id="question_liste" class="question_liste"></ul>
</div>



<div id="reponse" style="display:none" class="reponse_style">
</div>

</body>
</html>