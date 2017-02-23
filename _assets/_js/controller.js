app.controller('HomeController', function($scope) {
	var timestamp = new Date();
	$scope.date = timestamp;

	$scope.chapterData = [{
		text: "Symbole sind Bilder, die mir etwas sagen wollen. Ich kann sie verstehen.",
		img: "/_assets/_img/chapter11/competenceDone.png",
		popover: "Du hast diese Kompetenz am 25. Oktober 2016 erreicht!",
		date: timestamp
	},
	
	{
		text: "Da steht etwas! Ich kann Schrift von Bildern und Symbolen unterscheiden.",
		img: "/_assets/_img/chapter11/competenceDone.png",
		popover: "Du hast diese Kompetenz am 25. Oktober 2016 erreicht!",
		date: timestamp
	},
	
	{
		text: "Ich kann Silben klatschen oder schwingen.",
		img: "/_assets/_img/isInEducationalPlan.png",
		popover: "Mathe Zr Bis 10",
		popoverlist: ["Übe im Übungsheft auf Seite 13 Nr. 2- 5", "Arbeite mit dem Material auf der Lerntheke!", "Lies den Wochentext und klatsche ihn!", "Bearbeite den Arbeitsplan Nr. 3!"],
		date: timestamp	
	},
	
	{
		text: "Affe, Esel, Igel, Opa, Uhu: Ich kann sagen, welchen Laut ich am Anfang dieser Worte höre.",
		img: "/_assets/_img/chapter11/competenceUndone.png",
		popover: "Du hast diese Kompotenz noch nicht erreicht!",
		date: timestamp	
	},
	
	{
		text: "Ich kann das M m lesen und schreiben.",
		img: "/_assets/_img/chapter11/competenceUndone.png",
		popover: "Du hast diese Kompotenz noch nicht erreicht!",
		date: timestamp	
	}
	
	];
});