/***********************
* Actions de compositions pour Adobe Edge Animate
*
* Modifier ce fichier avec précaution, en veillant à conserver 
* les signatures et les commentaires de fonction commençant par « Edge » pour maintenir la 
* possibilité d’interagir avec ces actions depuis Adobe Edge Animate
*
***********************/
(function($, Edge, compId){
var Composition = Edge.Composition, Symbol = Edge.Symbol; // alias pour les classes Edge couramment utilisées

   //Edge symbol: 'stage'
   (function(symbolName) {
      
      
      

      Symbol.bindTriggerAction(compId, symbolName, "Default Timeline", 0, function(sym, e) {
         
         
         sym.$("Browning").hide();
         // Masquer un élément 
         sym.$("Poincon").hide();
         // Masquer un élément 
         sym.$("browningrevolverplaqueRecto").hide();
         // Masquer un élément 
         sym.$("FNHerstal").hide();
         // Masquer un élément 
         sym.$("plaquetteFleche").hide();
         
         
         
         
         
         

      });
      //Edge binding end

      Symbol.bindElementAction(compId, symbolName, "${bouton3}", "click", function(sym, e) {
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.$("Bouboutonton").is(":visible")) {
         	sym.$("Bouboutonton").hide();
         } else {
         	sym.$("Bouboutonton").show();
         }
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.$("bouton4").is(":visible")) {
         	sym.$("bouton4").hide();
         } else {
         	sym.$("bouton4").show();
         }
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.$("PoinconIntitule3").is(":visible")) {
         	sym.$("PoinconIntitule3").hide();
         } else {
         	sym.$("PoinconIntitule3").show();
         }
         
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.$("browningIntitule2").is(":visible")) {
         	sym.$("browningIntitule2").hide();
         } else {
         	sym.$("browningIntitule2").show();
         }
         
         
         sym.getSymbol("bouton3").playReverse();

      });
      //Edge binding end

      Symbol.bindElementAction(compId, symbolName, "${bouton4}", "click", function(sym, e) {
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.$("bouton2").is(":visible")) {
         	sym.$("bouton2").hide();
         } else {
         	sym.$("bouton2").show();
         }
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.$("bouton3").is(":visible")) {
         	sym.$("bouton3").hide();
         } else {
         	sym.$("bouton3").show();
         }
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.$("FNIntitule2").is(":visible")) {
         	sym.$("FNIntitule2").hide();
         } else {
         	sym.$("FNIntitule2").show();
         }
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.$("PlaquettesIntitule").is(":visible")) {
         	sym.$("PlaquettesIntitule").hide();
         } else {
         	sym.$("PlaquettesIntitule").show();
         }
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         sym.getSymbol("bouton4").playReverse();
         

      });
      //Edge binding end

      Symbol.bindElementAction(compId, symbolName, "${bouton2}", "click", function(sym, e) {
         // insérer le code du clic de souris ici
         sym.getSymbol("plaquetteFleche").getSymbol("fleche").play();
         
         sym.getSymbol("bouton2").playReverse();
         
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.$("Bouboutonton").is(":visible")) {
         	sym.$("Bouboutonton").hide();
         } else {
         	sym.$("Bouboutonton").show();
         }
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.$("bouton4").is(":visible")) {
         	sym.$("bouton4").hide();
         } else {
         	sym.$("bouton4").show();
         }
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.$("browningIntitule2").is(":visible")) {
         	sym.$("browningIntitule2").hide();
         } else {
         	sym.$("browningIntitule2").show();
         }
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.$("PoinconIntitule3").is(":visible")) {
         	sym.$("PoinconIntitule3").hide();
         } else {
         	sym.$("PoinconIntitule3").show();
         }
         

      });
      //Edge binding end

      

      

      

      

      Symbol.bindElementAction(compId, symbolName, "${Bouboutonton}", "click", function(sym, e) {
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         
         sym.getSymbol("Bouboutonton").playReverse();
         
         if (sym.$("bouton3").is(":visible")) {
         	sym.$("bouton3").hide();
         } else {
         	sym.$("bouton3").show();
         }
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.$("bouton2").is(":visible")) {
         	sym.$("bouton2").hide();
         } else {
         	sym.$("bouton2").show();
         }
         
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.$("PlaquettesIntitule").is(":visible")) {
         	sym.$("PlaquettesIntitule").hide();
         } else {
         	sym.$("PlaquettesIntitule").show();
         }
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.$("FNIntitule2").is(":visible")) {
         	sym.$("FNIntitule2").hide();
         } else {
         	sym.$("FNIntitule2").show();
         }
         
         
         

      });
      //Edge binding end

   })("stage");
   //Edge symbol end:'stage'

   //=========================================================
   
   //Edge symbol: 'bouton'
   (function(symbolName) {   
   
      

      

      

      Symbol.bindTriggerAction(compId, symbolName, "Default Timeline", 405, function(sym, e) {
         // insérer le code ici
         sym.stop();

      });
      //Edge binding end

      Symbol.bindElementAction(compId, symbolName, "${boutonOn}", "click", function(sym, e) {
         // insérer le code du clic de souris ici
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.getComposition().getStage().$("Browning").is(":visible")) {
         	sym.getComposition().getStage().$("Browning").hide();
         } else {
         	sym.getComposition().getStage().$("Browning").show();
         }
         
         // Masquer un élément 
         sym.getComposition().getStage().$("Poincon").hide();
         
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.getComposition().getStage().$("browningrevolveRecto").is(":visible")) {
         	sym.getComposition().getStage().$("browningrevolveRecto").hide();
         } else {
         	sym.getComposition().getStage().$("browningrevolveRecto").show();
         }
         

      });
      //Edge binding end

   })("bouton");
   //Edge symbol end:'bouton'

   //=========================================================
   
   //Edge symbol: 'bouton3'
   (function(symbolName) {   
   
      Symbol.bindTriggerAction(compId, symbolName, "Default Timeline", 405, function(sym, e) {
         // insérer le code ici
         sym.stop();

      });
      //Edge binding end

      Symbol.bindElementAction(compId, symbolName, "${boutonOn3}", "click", function(sym, e) {
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.getComposition().getStage().$("browningrevolver").is(":visible")) {
         	sym.getComposition().getStage().$("browningrevolver").hide();
         } else {
         	sym.getComposition().getStage().$("browningrevolver").show();
         }
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.getComposition().getStage().$("FNHerstal").is(":visible")) {
         	sym.getComposition().getStage().$("FNHerstal").hide();
         } else {
         	sym.getComposition().getStage().$("FNHerstal").show();
         }
         
         // Masquer un élément 
         sym.getComposition().getStage().$("plaquetteFleche").hide();
         

      });
      //Edge binding end

   })("bouton3");
   //Edge symbol end:'bouton3'

   //=========================================================
   
   //Edge symbol: 'bouton2'
   (function(symbolName) {   
   
      Symbol.bindTriggerAction(compId, symbolName, "Default Timeline", 405, function(sym, e) {
         // insérer le code ici
         sym.stop();

      });
      //Edge binding end

      Symbol.bindElementAction(compId, symbolName, "${boutonOn2}", "click", function(sym, e) {
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.getComposition().getStage().$("plaquetteFleche").is(":visible")) {
         	sym.getComposition().getStage().$("plaquetteFleche").hide();
         } else {
         	sym.getComposition().getStage().$("plaquetteFleche").show();
         }
         
         // Masquer un élément 
         sym.getComposition().getStage().$("FNHerstal").hide();
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.getComposition().getStage().$("browningrevolver").is(":visible")) {
         	sym.getComposition().getStage().$("browningrevolver").hide();
         } else {
         	sym.getComposition().getStage().$("browningrevolver").show();
         }

      });
      //Edge binding end

      

   })("bouton2");
   //Edge symbol end:'bouton2'

   //=========================================================
   
   //Edge symbol: 'bouton4'
   (function(symbolName) {   
   
      Symbol.bindTriggerAction(compId, symbolName, "Default Timeline", 405, function(sym, e) {
         // insérer le code ici
         sym.stop();

      });
      //Edge binding end

      Symbol.bindElementAction(compId, symbolName, "${boutonOn4}", "click", function(sym, e) {
         // insérer le code du clic de souris ici
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.getComposition().getStage().$("browningrevolveRecto").is(":visible")) {
         	sym.getComposition().getStage().$("browningrevolveRecto").hide();
         } else {
         	sym.getComposition().getStage().$("browningrevolveRecto").show();
         }
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.getComposition().getStage().$("Poincon").is(":visible")) {
         	sym.getComposition().getStage().$("Poincon").hide();
         } else {
         	sym.getComposition().getStage().$("Poincon").show();
         }
         
         // Masquer un élément 
         sym.getComposition().getStage().$("Browning").hide();

      });
      //Edge binding end

      

   })("bouton4");
   //Edge symbol end:'bouton4'

   //=========================================================
   
   //Edge symbol: 'browning'
   (function(symbolName) {   
   
   })("browning");
   //Edge symbol end:'browning'

   //=========================================================
   
   //Edge symbol: 'Browning'
   (function(symbolName) {   
   
   })("Browning");
   //Edge symbol end:'Browning'

   //=========================================================
   
   //Edge symbol: 'Poincon'
   (function(symbolName) {   
   
   })("Poincon");
   //Edge symbol end:'Poincon'

   //=========================================================
   
   //Edge symbol: 'FNHerstal'
   (function(symbolName) {   
   
   })("FNHerstal");
   //Edge symbol end:'FNHerstal'

   //=========================================================
   
   //Edge symbol: 'plaquettes'
   (function(symbolName) {   
   
   })("plaquettes");
   //Edge symbol end:'plaquettes'

   //=========================================================
   
   //Edge symbol: 'crosse'
   (function(symbolName) {   
   
   })("crosse");
   //Edge symbol end:'crosse'

   //=========================================================
   
   //Edge symbol: 'fleche'
   (function(symbolName) {   
   
      

   })("fleche");
   //Edge symbol end:'fleche'

   //=========================================================
   
   //Edge symbol: 'plaquetteFleche'
   (function(symbolName) {   
   
   })("plaquetteFleche");
   //Edge symbol end:'plaquetteFleche'

   //=========================================================
   
   //Edge symbol: 'Bouboutonton'
   (function(symbolName) {   
   
      Symbol.bindTriggerAction(compId, symbolName, "Default Timeline", 405, function(sym, e) {
         // insérer le code ici
         sym.stop();

      });
      //Edge binding end

      Symbol.bindElementAction(compId, symbolName, "${boutonOn1}", "click", function(sym, e) {
         // insérer le code du clic de souris ici
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.getComposition().getStage().$("Browning").is(":visible")) {
         	sym.getComposition().getStage().$("Browning").hide();
         } else {
         	sym.getComposition().getStage().$("Browning").show();
         }
         
         // Masquer un élément 
         sym.getComposition().getStage().$("Poincon").hide();
         
         
         // Définir un sélecteur permettant de masquer ou d’afficher un élément 
         if (sym.getComposition().getStage().$("browningrevolveRecto").is(":visible")) {
         	sym.getComposition().getStage().$("browningrevolveRecto").hide();
         } else {
         	sym.getComposition().getStage().$("browningrevolveRecto").show();
         }
         
         

      });
      //Edge binding end

   })("Bouboutonton");
   //Edge symbol end:'Bouboutonton'

})(window.jQuery || AdobeEdge.$, AdobeEdge, "EDGE-1962861");