// Tool Windows management.
// Copyright Marco Cerulli Consulting ©
// Written by Neil Otupacca.

(function($) {
    $(function() {
        // Personalizzazione dei tag <select>.
        var doInitSelect = function(sel) {
            var isEnabled = sel.is(":enabled");
            var div = sel.prev("div[data-te-select-form-outline-ref]");
            var pr = (div.find("span.absolute[data-te-select-clear-btn-ref]").length > 0) ? "pr-14" : "pr-10";
            var peer = div.find("input.peer[data-te-select-input-ref]");
            peer.removeClass("px-3").addClass(pr + " pl-3 overflow-x-hidden text-ellipsis");

            if (sel.attr("aria-required") == "true") peer.attr("required", "required");

            if (isEnabled) peer.removeClass("bg-transparent").addClass("bg-white");

            // Copia l'eventuale property "title" di <select> nell'<input> generato
            // da 'tw-elements.umd.min.js' (tw-elements).
            var title = sel.prop("title");
            if (title) peer.prop("title", title);

            // Bind dell'evento "onchange" per il <select> corrente.
            // Nota: l'handler ha un bind anche con l'evento "select:update", questo viene triggerato
            //       quando si vuole eseguire solo questo handler e non gli eventuali altri handler
            //       associati allo stesso <select>.
            sel.on("change select:update", function(evt, init) {
                // Aggiunge o rimuove la classe "no-content" all'input di mirror generato da tailwind.
                var vl = $(this).val();  // vl = null oppure stringa del value => per un select single-selection.
                                         // vl = array dei value selezionati   => per un select multi-selection.
                var bSelection = (vl === null || vl === "") ? false : ((typeof(vl) == "string") ? true : vl.length > 0);
                var div = $(this).parent("div[data-te-select-wrapper-ref]").find("div[data-te-select-form-outline-ref]");
                var inp = div.find("input.peer[data-te-select-input-ref]");
                (bSelection) ? inp.removeClass("no-content") : inp.addClass("no-content");

                // Nel caso la stringa dell'input sia troppo larga, potrebbe risultare allineata a destra,
                // allinea a sinistra.
                window.setTimeout(function() { inp.scrollLeft(0); }, 10);

                // Copia l'eventuale property "title" della <option> selezionata nell'<input> generato
                // da 'tw-elements.umd.min.js' (tw-elements).
                var title = $(this).find("option:selected").prop("title");
                if (title) inp.prop("title", title);


                ///////////////////////////////////////////////////////////////////////////////////////////
                // Escamotage per la bug della <select> con l'attributo data-te-select-clear-button="true".

                // Nascondi l'icona di clear se è visibile malgrado il select non abbia un valore selezionato.
                if (!bSelection) div.find("[data-te-select-clear-btn-ref]").css("display", "none");

                if (typeof(init) != "undefined" && init === "init") {
                    // Azioni eseguite solo se init === "init" (solo dal trigger dopo il binding).
                    var state = div.find("div.group").next("div.absolute");

                    // Se la stringa del <div> non è empty, rendila tale.
                    if (state.length > 0 && state.html().length > 0) state.html("");
                }
            }).trigger("select:update", "init");  // L'evento "select:update" riceve la stringa "init"
                                                  // un'unica volta solo da questo trigger dopo il binding.
        };

        // Determina se l'evento 'oninput' è supportato, in caso contrario, utilizza l'evento 'onkeyup onchange oncut onpaste'.
        var eventName = ($("input.peer").prop("oninput") === undefined) ? "keyup" : "input";
        var eventAll = (eventName == "input") ? eventName : eventName + " change cut paste";

        // Aggiunge o rimuove la classe "no-content" agli input (regolari o associati ad un <select>).
        var doInitInput = function(evt) {
            var inp = $(this);
            var bText = inp.val().trim().length > 0;   // un contenuto di soli white-char viene considerato "no-content".
            var bLabel = inp.val().length > 0;         // i white-char sono considerati come contenuto valido.
            var bWasEmpty = inp.hasClass("no-chars");  // l'input era già vuoto prima di questa chiamata.
            (bText) ? inp.removeClass("no-content") : inp.addClass("no-content");
            (bLabel) ? inp.next("label").removeClass("no-chars") : inp.next("label").addClass("no-chars");

            // La variabile 'trusted' è true se questa callback è stata invocata a causa di una interazione
            // dell'utente (che ha digitato nell'input).
            var trusted = (evt.originalEvent) ? evt.originalEvent.isTrusted : false;

            // Assegna il focus all'input (e poi rimuovilo) alle seguenti condizioni:
            //   • doInitInput() è stato invocato da trigger() o da triggerHandler().
            //   • l'input non ha attualmente il focus.
            //   • prima che doInitInput() fosse invocato, l'input non era vuoto (bWasEmpty == false).
            //   • ora l'input è vuoto (bLabel == false).
            // Nota: la label dell'input si muove nella posizione corretta quando un input vuoto viene
            //       popolato programmaticamente.
            //       Quando, invece, un input con un contento viene svuotato programmaticamente, serve
            //       assegnare il focus perché la label dell'input si muova nella posizione corretta.
            if (!trusted && this !== document.hasFocus() && !bLabel && !bWasEmpty) {
                var self = this;
                window.setTimeout(function() {
                    self.focus({ preventScroll: true });  // Previeni lo scroll nel caso l'input non si
                    self.blur();                          // trovi nel viewport.
                }, 10);
            }
        };

        // Inizializza tutti i <select[data-te-select-init]> presenti durante il caricamento della pagina.
        $("select[data-te-select-init]").each(function() {
            doInitSelect($(this));
        });

        // Inizializza tutti gli <input.peer> presenti durante il caricamento della pagina.
        $("input.peer").on(eventAll, doInitInput).trigger(eventName);


        // Le funzioni selectEventInit() e inputEventInit() possono essere ottenute da altri script
        // richiamando il custom event "get:input:inits", le due funzioni vengono assegnate a due
        // properties dell'oggetto ritornato da .on("get:input:inits", function(evt, fnObj) { }).
        // L'handler deve essere invocato tramite il metodo triggerHandler() (che ritorna l'ultimo
        // valore ritornato dall'handler) e non da trigger() che ritorna l'oggetto jQuery (chaining).
        // Le due funzioni possono poi essere richiamate dal chiamante per assegnare dinamicamente
        // gli eventi necessari a elementi <select> e <input> creati dinamicamente dopo il caricamento
        // della pagina.
        // Esempio (script in un file diverso da "inputs.js"):
        //   // Ottieni le due funzioni definite all'interno dello script "inputs.js".
        //   var fnObj = $("body").triggerHandler("get:input:inits");  // Ritorna le due funzioni nell'oggetto fnObj.
        //   var fnInitSelect = fnObj.selectEventInit;
        //   var fnInitInput = fnObj.inputEventInit;
        //
        //   // Richiama le funzioni definite all'interno dello script "inputs.js".
        //   fnInitSelect(sel);  // sel è un oggetto jQuery che referenzia un elemento <select>.
        //   fnInitInput(inp);   // inp è un oggetto jQuery che referenzia un elemento <input>.
        var selectEventInit = function(sel) {
            // Inizializza un <select> creato dinamicamente (a caricamente avvenuto della pagina che lo contiene).
            doInitSelect(sel);
        };

        var inputEventInit = function(inp) {
            // Inizializza un <input> creato dinamicamente (a caricamento avvenuto della pagina che lo contiene).
            inp.on(eventAll, doInitInput).trigger(eventName);
        };

        $("body").on("get:input:inits", function(evt) {
            // Invocare questo evento con triggerHandler() in modo che il valore ritornato
            // dal seguente return sia accessibile tramite il valore di return di triggerHandler().
            return { "selectEventInit": selectEventInit, "inputEventInit": inputEventInit };
        });


        // Se una <option> è selezionata (selected) al boot della pagina, il click sull'icona di
        // clear non rimuove correttamente l'attributo "data-te-input-state-active" dell'input (bug).
        // Rimuovi esplicitamente l'attributo dell'input e della label se non lo è già.
        $("span[data-te-select-clear-btn-ref]").on("click", function(evt) {
            $(this).prevAll("input.peer[data-te-select-input-ref][data-te-input-state-active]")
                   .removeAttr("data-te-input-state-active")
                   .removeData("te-input-state-active");
            $(this).prevAll("label[data-te-select-label-ref][data-te-input-state-active]")
                   .removeAttr("data-te-input-state-active")
                   .removeData("te-input-state-active");
        });


        // Aggiungi l'icona di "show/hide password".
        $("[data-te-input-wrapper-init] input[type=password]").filter(":enabled").each(function() {
            $(this).after("<span class=\"pw-view\">" +
                            "<svg viewBox=\"0 0 576 512\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z\"></path></svg>" +
                            "<svg viewBox=\"0 0 640 512\" xmlns=\"http://www.w3.org/2000/svg\" style=\"display: none;\"><path d=\"M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z\"></path></svg></span>");
        });

        // Mostra/nascondi la password.
        $("input.peer[type=password]:not(:disabled) + span.pw-view").on("mousedown mouseup mouseleave", function(evt) {
            var span = $(this);
            var pw = span.prev("input.peer");
            if (pw.length <= 0) return;

            evt.stopPropagation();

            // Determina se il campo della password per il login è impostato con il "type" text o
            // password e che transizione deve essere effettuata.
            var switchToText = evt.type == "mousedown";
            var isText = pw.prop("type") == "text";
            if (!(switchToText ^ isText)) return;  // Ritorna se lo stato non necessita modifiche.

            var svgs = $(this).find("svg");  // Ritorna le due icone: show e hide.

            // Switch del tipo di campo e dell'icona.
            pw.prop("type", (switchToText) ? "text" : "password");

            // Utilizzare 'initial' per visualizzare l'icona.
            svgs.eq(0).css("display", (switchToText) ? "none" : "initial");
            svgs.eq(1).css("display", (switchToText) ? "initial" : "none");
        });
    });
})(jQuery);
