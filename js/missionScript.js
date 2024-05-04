// Gestion de la mise en forme en cas de message d'erreur lors de la soumission du formulaire d'ajout ou de modification:
if ($("#formMessage p").text().length != 0) {
  $("#mainContent").css("margin-top", "31px");
  $("#formMessage").css("margin-bottom", "31px");
  $("#mainContent h2").css("margin-bottom", "35px");
  $("#missionForm select:nth-child(8)").css("margin-bottom", "35px");
  $("#missionForm select:nth-child(9)").css("margin-bottom", "35px");
}

// Gestion de la mise en forme en cas de message d'erreur lors de la confirmation de suppression:
if ($("#messageContent p").text().length != 0) {
  $("#mainContent").css("height", "561px");
}

// Gestion du scroll dans le cas d'un grand nombre de missions:
if ($("#missionListContainer").height() > 632) {
  $("#mainContent").css({ "align-items": "normal", "overflow-y": "scroll" });
}
