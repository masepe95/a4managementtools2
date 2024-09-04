// Tool Windows management.
// Copyright Marco Cerulli Consulting ©
// Written by Neil Otupacca.

(function($) {
    $(function() {
        // Gestione per il cambio dell'utente impersonato.
        $("select#impersonated-employee").on("change select:update", function(evt, init) {
            // Nota: questo handler è richiamato dall'evento "select:update" dallo script "inputs.js"
            //       durante l'inizializzazione del <select> (metodo doInitSelect()).
            var sel = $(this);

            var peer = sel.prev("div[data-te-select-form-outline-ref]").find("input.peer[data-te-select-input-ref]");
            if (sel.val() != sel.data("curr-id")) peer.removeClass("bg-white").addClass(sel.data("impersonated-marker"));
            else peer.removeClass(sel.data("impersonated-marker")).addClass("bg-white");

            $.ajax({
                type: "post",
                url: "/impersonated/change",
                dataType: "json",
                data: {
                    _token: sel.data("csrf-token"),  // Il token csrf è necessario.
                    impersonated_id: sel.val(),
                },
                success: function(data, textStatus, jqXHR) {
                    // Itera tutte entries di selezione della pagina di amministrazione e aggiorna
                    // l'attributo data-can-view ('yes' oppure 'no').
                    for (var page of data.pageAccesses) {
                        // La classe "admin-selector" che tiene conto di "can-view" fa riferimento
                        // all'attributo, non a data().
                        $("#" + page.name).attr("data-can-view", page.access);
                    }

                    // Dopo che l'utente impersonato è cambiato, aggiorna i dati della pagina
                    // di admin correntemente selezionata.
                    var currPage = $(".admin-selector.admin-selected");
                    if (currPage.length <= 0) return;

                    var loadPage = "load-" + currPage.prop("id").slice(4) + "-page";
                    if ((typeof(init) == "undefined" || init !== "init") &&
                        typeof(pageLoadCallbacks[loadPage]) == "function") pageLoadCallbacks[loadPage]();
                    else {
                        // Imposta l'abilitazione del filtro (il campo `employee_role` è sempre valido,
                        // quindi l'attributo "data-te-select-secondary-text" è sempre presente e
                        // l'altezza delle <option> è sempre 58, vedi "data-te-select-option-height").
                        // Non serve invocare la funzione updateSelectOptionHeight("#impersonated-employee").
                        updateSelectFilter("#impersonated-employee");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var resp = JSON.parse(jqXHR.responseText);
                    console.log(resp.message);
                }
            });
        });

        // Gestione del cambio della lingua.
        $("select#language").on("change", function(evt, init) {
            var sel = $(this);

            var url = sel.data("route-change-lang");  // Ottieni la route per il cambio lingua.
            var locale = sel.val();
            window.location.href = url + "?locale=" + locale;
        });

        // Lingua correntemente selezionata.
        var currentLanguage = $("html").prop("lang");

        // Caricamento della foto dell'utente.
        // La funzione loadEmployeePhoto() permette di essere invocata, aggiornando la foto
        // dell'utente, quando la si modifica nella pagina del profilo e dell'employee.
        var loadEmployeePhoto = function() {
            $.ajax({
                type: "post",
                url: "/get-photo",
                dataType: "json",
                data: { _token: $("#user-photo").data("csrf-token") },  // Il token csrf è necessario.
                success: function(data, textStatus, jqXHR) {
                    $("#user-photo").prop("src", data.src);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#user-photo").prop("src", "images/no-user.png");
                }
            });
        };

        // Aggiorna il <select#impersonated-employee> quando vengono modificati e dati
        // di un "Profile", "Customer" o "Employee".
        var updateImpersonatingSelect = function() {
            $.ajax({
                type: "post",
                url: "/impersonated/index",
                dataType: "json",
                data: {
                    "impersonated-employee": $("#impersonated-employee").val(),
                    _token: $("#impersonated-employee").data("csrf-token")  // Il token csrf è necessario.
                },
                success: function(data, textStatus, jqXHR) {
                    // Se il valore data.selected è false, allora è appena stato eliminato un employee.
                    // Non impostare il parametro "init" così che il nuovo customer sia selezionato.
                    $("#impersonated-employee").html(data.employees).triggerHandler("select:update", (data.selected) ? "init" : "");
                },
            });
        };

        var ajaxError = function(jqXHR, errElem) {
            var msg = JSON.parse(jqXHR.responseText).message;

            // Output dell'errore originale (nel caso sia mappato con gli errori in "data-sql-error").
            console.log(msg);

            // Se la sessione è scaduta, ricarica la pagina, questa verrà poi reindirizzata al login.
            if (msg.indexOf("CSRF token mismatch") >= 0) location.reload();
            else {
                // Nel caso di un custom-error (ad esempio una violazione di un constraint),
                // determina se il messaggio di errore contiene una delle stringhe delle key 'match'.
                var customErrors = $(errElem).data("sql-error");
                if (typeof(customErrors) != "undefined") {
                    // Formato: array di object contenenti le key 'match' e 'errMsg'.
                    try {
                        // Vedi la key 'sql-error' nei file di multilingua (rispettare la seguente sequenza di .replace()).
                        var errMatches = JSON.parse(customErrors.replace(/'/g, "\"").replace(/’/g, "'").replace(/”/g, "\\\""));
                        for (var obj of errMatches) {  // Itera l'array di objects.
                            if (msg.indexOf(obj.match) >= 0) {
                                // L'errore in msg contiene la stringa 'match' corrente, utilizzza
                                // la relativa stringa 'errMsg' come messaggio di errore.
                                msg = obj.errMsg;
                                break;
                            }
                        }
                    } catch (e) { console.log("JSON parse error: " + e.message); }
                }

                $(errElem).html(msg).removeClass("hidden");
            }
        };

        // Salva le posizioni degli scrollbar verticali ogni volta che si abbandona la pagina.
        // Nota: utilizzare l'evento "beforeunload" anziché "unload", quest'ultimo, infatti, viene invocato
        //       dopo che la nuova pagina viene pre caricata.
        //       Questa modalità "differita" non crea problemi se la nuova pagina è diversa da quella corrente,
        //       ma nel caso di cambio lingua e di un refresh esplicito (viene ricaricata la stessa pagina),
        //       il valore della sessione impostato durante il pre caricamento è quello precedente al valore che
        //       sarebbe poi salvato in modo differito durante l'evento "unload".
        $(window).on("beforeunload", function(evt) {
            setSessionValue("adm-vscroll-position-aside", $("#admin-aside").scrollTop());

            // Ottieni la pagina correntemente aperta.
            var currPage = $(".admin-selector.admin-selected");
            if (currPage.length <= 0) return;

            setSessionValue("adm-vscroll-position-" + currPage.prop("id").slice(4), $(window).scrollTop());
        });

        // Implementazione dello smooth scrolling.
        var timerIds = [null, null];
        var animateScroll = function(container, endPos, duration) {
            // Duration di default in millisecondi.
            if (duration === undefined) duration = 500;
            var startPos = container.scrollTop();
            var side = (container.prop("id") === "admin-aside") ? 0 : 1;

            // Aggiorna la posizione dello scrollbar ogni 10ms (time).
            var step = 0, time = 10, diffPos = endPos - startPos;
            var curveExponent = 3.5;

            // Callback di aggiornamento della posizione dello scrollbar.
            var scrollFunc = function() {
                var tm = (++step) * time;

                if (tm >= duration) {
                    // Posizione finale raggiunta.
                    container.scrollTop(endPos);
                    timerIds[side] = null;
                }
                else {
                    var ratio = tm / duration;  // Range: ]0 a 1[.

                    // Trasla la retta in una easing-curve.
                    ratio = (ratio < 0.5) ? Math.pow(ratio * 2, curveExponent) / 2 :
                                            1 - (Math.pow((1 - ratio) * 2, curveExponent) / 2);

                    container.scrollTop(startPos + (diffPos * ratio));

                    timerIds[side] = window.setTimeout(scrollFunc, time);  // Invocazione asincrona.
                }
            };

            if (timerIds[side] !== null) window.clearTimeout(timerIds[side]);
            timerIds[side] = window.setTimeout(scrollFunc, time);  // Invocazione asincrona.
        };


        // Ritorna alla home-page.
        $("#home-page").on("click", function(evt) {
            window.location.href = '/';
        });

        //////////////////////////////////////////////////////////////////////////////////
        // Gestione degli expander e dei link delle pagine di amministrazione.

        $(".expander").on("click", function(evt, scrollFunc) {
            var exp = $(this);
            var expanderName = exp.data("expander-name");
            var status = "close";

            var span = exp.find(".exp-arrow");
            var blk = exp.next(".exp-block");

            if (span.hasClass("rotate-[-180deg]")) {
                span.removeClass("rotate-[-180deg]");
                blk.slideUp("slow", function() { if (typeof(scrollFunc) == "function") scrollFunc(); });
            }
            else {
                span.addClass("rotate-[-180deg]");
                blk.slideDown("slow", function() { if (typeof(scrollFunc) == "function") scrollFunc(); });
                status = "open";
            }

            // Salva nello storage lo stato dell'expander corrente.
            setSessionValue("adm-exp-" + expanderName, status);
        });

        //////////////////////////////////////////////////////////////////////
        // Classi per i tag <input> e relative <label> generate dinamicamente.
        var inputClasses = $("body").data("input-classes");
        var labelClasses = $("body").data("label-classes");

        /////////////////////////////////////////////////////////////////////////////
        // Array di funzioni richiamata quando si apre una pagina di amministrazione.
        var pageLoadCallbacks = { };

        // Gestione del click per la visualizzazione dei blocchi.
        $(".exp-block .admin-selector").on("click", function(evt, scrollFunc) {
            // Determina l'id del blocco da visualizzare:
            // Esempio:
            //   adm-profile          =>  profile-block
            //   adm-personal-groups  =>  personal-groups-block
            var lnk = $(this);
            var onShowFunc = lnk.prop("id").slice(4);  // key della funzione nell'array pageLoadCallbacks[].
            var blkId = lnk.prop("id").slice(4) + "-block";
            var toOpenBlock = $("#" + blkId);

            // Salva nello storage la pagina correntemente aperta.
            setSessionValue("adm-curr-page", "adm-" + onShowFunc);

            // Ottieni la pagina (eventualmente le pagine) da chiudere e salva la posizione dello scroll.
            var toCloseColl = $(".page-block").filter(function() {
                return $(this).prop("id") != blkId && $(this).is(":visible");
            });

            var pos = $(window).scrollTop();
            toCloseColl.each(function() { setSessionValue("adm-vscroll-position-" + $(this).prop("id").slice(0, -6), pos); });

            $(".exp-block .admin-selector").removeClass("admin-selected");
            lnk.removeClass("cursor-pointer").addClass("admin-selected");

            var loadPage = "load-" + onShowFunc + "-page";
            loadPage = (typeof(pageLoadCallbacks[loadPage]) == "function") ? pageLoadCallbacks[loadPage] :
                                                                             function() { };

            var onShow = function() {
                // Evento utilizzabile dalle pagine che necessitano il meccanismo di lazy-load
                // e del trigger di 'eventName' al termine dello slideDown() della pagina corrente.
                $(document).triggerHandler("page-loaded:" + onShowFunc);

                // Esegui l'eventuale scroll.
                if (typeof(scrollFunc) == "function") scrollFunc();
                else {
                    // Ripristina l'ultima posizione dello scrollbar della pagina che si è appena aperta.
                    var pos = getSessionValue("adm-vscroll-position-" + onShowFunc);
                    if (pos !== false) {
                        pos = parseInt(pos, 10);
                        if (!isNaN(pos) && pos > 0) {
                            animateScroll($(window), pos);
                        }
                    }
                }
            };

            if (toCloseColl.length > 0) toCloseColl.slideUp(500, function() {
                if (toOpenBlock.is(":hidden")) toOpenBlock.slideDown(500, onShow);
                loadPage();
            });
            else if (toOpenBlock.is(":hidden")) {
                toOpenBlock.slideDown(500, onShow);
                loadPage();
            }
        });

        // Rimuovi le classi "collapse" e "h-0" ed aggiungi lo style "display: none".
        // Nota: le classi "collapse" e "h-0" permettono di nascondere tutti i blocchi che non sono
        //       inizialmente visibili (solo quello con la property "data-visible-block" lo sarà).
        //       Lo script "tw-elements.umd.min.js" (tw-elements script core) ha così la possibilità
        //       di calcolare la larghezza della label associata ad ogni <select> prima di rendere
        //       "hidden" i blocchi non visibili (quando un tag è hidden, o è contenuto in un
        //       elemento hidden, le sue dimensioni non sono computabili).
        // Nota: jQuery (questo script) è eseguito sempre dopo lo script "tw-elements.umd.min.js".
        $(".page-block").not("[data-visible-block]").css("display", "none").removeClass("collapse h-0");

        // Numero di expander in stato di animazione di cui attendere il termine prima di ripristinare
        // la posizione dello scrollbar verticale dell'area "aside".
        var expActions = 0;

        var restoreAsideScrollPos = function() {
            // Ripristina l'ultima posizione dello scrollbar verticale dell'area "aside".
            var pos = getSessionValue("adm-vscroll-position-aside");
            if (pos !== false) {
                var pos = parseInt(pos, 10);
                if (!isNaN(pos) && pos > 0) {
                    animateScroll($("#admin-aside"), pos);  // Ultima posizione salvata dell'area "aside" a sinistra.
                }
            }
        };

        // Ripristina l'ultimo stato dell'expander delle pagine di profile (salvato nello storage di sessione).
        var stg = getSessionValue("adm-exp-profile");
        if (stg !== false) {
            var bOpen = (stg === "open");
            var ex = $("div.expander[data-expander-name=profile]");
            if (ex.find(".exp-arrow").hasClass("rotate-[-180deg]") ^ bOpen) {
                expActions++;  // Incrementa il numero di animazioni degli expander di cui attendere il termine.
                ex.trigger("click", function() { if ((--expActions) <= 0) restoreAsideScrollPos(); });
            }
        }

        if (expActions <= 0) restoreAsideScrollPos();  // Nel caso non ci siano state animazioni degli expander.

        // Ripristina l'ultimo stato dell'expander delle pagine di admin (salvato nello storage di sessione).
        stg = getSessionValue("adm-exp-admin");
        if (stg !== false) {
            var bOpen = (stg === "open");
            var ex = $("div.expander[data-expander-name=admin]");
            if (ex.find(".exp-arrow").hasClass("rotate-[-180deg]") ^ bOpen) {
                expActions++;  // Incrementa il numero di animazioni degli expander di cui attendere il termine.
                ex.trigger("click", function() { if ((--expActions) <= 0) restoreAsideScrollPos(); });
            }
        }

        // Ripristina l'ultimo stato dell'expander delle pagine di super-admin (salvato nello storage di sessione).
        stg = getSessionValue("adm-exp-super-admin");
        if (stg !== false) {
            var bOpen = (stg === "open");
            var ex = $("div.expander[data-expander-name=super-admin]");
            if (ex.find(".exp-arrow").hasClass("rotate-[-180deg]") ^ bOpen) {
                expActions++;  // Incrementa il numero di animazioni degli expander di cui attendere il termine.
                ex.trigger("click", function() { if ((--expActions) <= 0) restoreAsideScrollPos(); });
            }
        }

        // Apri l'ultima pagina di admin aperta (salvata nello storage di sessione).
        // Nota: ritarda l'esecuzione dell'apertura della pagina in modo che il resto del codice
        //       di questo script sia caricato, infatti, il trigger per il click dei <div#adm-XXX>
        //       richiama l'handler "click" dei tag ".exp-block .admin-selector", questa invoca una
        //       funzione dell'array pageLoadCallbacks[], ma le funzioni da assegnare all'array non
        //       esistono ancora in questo punto.
        window.setTimeout(function() {
            stg = getSessionValue("adm-curr-page");
            if (stg !== false) $("div#" + stg).trigger("click", function() {
                // Ripristina l'ultima posizione dello scrollbar verticale dell'area "content".
                var pos = getSessionValue("adm-vscroll-position-" + stg.slice(4));
                if (pos !== false) {
                    var pos = parseInt(pos, 10);
                    if (!isNaN(pos) && pos > 0) {
                        animateScroll($(window), pos);  // Ultima posizione salvata dell'area "content" a destra.
                    }
                }
            });
        }, 10);


        //////////////////////////////////////////////////////////////////////////////////
        // Inizializzazione degli elementi <select> e <input> creati dinamicamente.

        // Funzioni per l'inizializzazione degli elementi <select> e <input>.
        // Nota: oltre ad inizializzare gli elementi, eseguono il bind dei rispettivi
        //       eventi onchange e oninput.
        var fnInitSelect = function() { };  // Fake function.
        var fnInitInput = fnInitSelect;     // Fake function (fnInitSelect === fnInitInput => true).

        var getInitFuncs = function() {
            // Ottieni le due funzioni di inizializzazione dinamica (se non lo sono già).
            // Nota: le due funzioni sono definite all'interno dello script "inputs.js".
            // Nota: le due funzioni sono identiche solo se sono quelle fake iniziali.
            if (fnInitSelect === fnInitInput) {
                // Ritorna le due funzioni tramite triggerHandler(), questo metodo non ritorna
                // l'oggetto jQuery (chaining) come trigger(), ma l'ultimo valore ritornato
                // dallo statement return dall'handler del custom event "get:input:inits".
                var fnObj = $("body").triggerHandler("get:input:inits");

                if (typeof(fnObj.selectEventInit) == "function" && typeof(fnObj.inputEventInit) == "function") {
                    // Sovrascrivi le due funzioni fake con quelle effettive definite in "inputs.js".
                    fnInitSelect = fnObj.selectEventInit;
                    fnInitInput  = fnObj.inputEventInit;
                }
            }
        };

        // Utility per la gestione dinamica del "data-te-select-filter" nei tag <select>.
        var updateSelectFilter = function(selectQuery, filterString) {
            var sel = $(selectQuery);
            var filterOn = sel.find("option:not([hidden])").length > parseInt(sel.data("search-threshold"), 10);

            var teSel = te.Select.getInstance(sel.get(0));

            // Ripristina la stringa di "Search..." (se è specificata).
            if (teSel.filterInput !== null && typeof(filterString) == "string" &&
                filterString.length > 0 && filterString !== teSel.filterInput.value) {

                // Imposta la stringa di "Search...".
                teSel.filterInput.value = filterString;

                // Notifica la modifica della nuova stringa di search.
                window.setTimeout(function() {
                    teSel.filterInput.dispatchEvent(new Event("input", { bubbles: false }));
                }, 500);
            }

            sel.attr("data-te-select-filter", (filterOn) ? "true" : "false");
            teSel._config.selectFilter = filterOn;

            sel.data("te-select-filter", filterOn)
            teSel._classes.teSelectFilter = (filterOn) ? "true" : "false";
        };

        // Utility per la gestione dinamica del "data-te-select-option-height" nei tag <select>.
        var updateSelectOptionHeight = function(selectQuery) {
            var sel = $(selectQuery);

            // Determina se c'è almeno una <option> con l'attributo "data-te-select-secondary-text".
            var height = (sel.find("option[data-te-select-secondary-text]").length > 0) ? 52 : 38;

            sel.attr("data-te-select-secondary-text", height);
            var teSel = te.Select.getInstance(sel.get(0));
            teSel._config.selectOptionHeight = height;

            // L'altezza del dropdown va ricalcolata in base alla nuova altezza e il numero
            // di <option> visibili.
            teSel._dropdownHeight = height * teSel._config.selectVisibleOptions;

            sel.data("te-select-secondary-text", height);
        }

        var updateSelectOptions = function(selectQuery, optList, props) {
            var opts = "";
            var icon = props.icon ?? false;
            var multi = props.multi ?? false;
            var single = props.single ?? false;

            // Costruisci le <option> del <select> con i dati della collection optList.
            // props = { id: "id",          // Nome della property per l'id nell'oggetto props.
            //          label: "label",     // Nome della property per la label nell'oggetto props.
            //          icon: "src",        // Nome della property per l'icona nell'oggetto props (assente se non usata).
            //          multi: "selection"  // Nome della stringa per la selezione multipla nell'oggetto props.
            //                              // Se il valore della props.multi di optList è "on", l'option viene
            //                              // selezionata, multi è assente se il <select> non è multiple-selection.
            //          single: id }        // Id della <option> da selezionare nel <select> single-selection.
            //                              // La property single è assente se il <select> non è single-selection.
            for ( var n = 0 ; n < optList.length ; n++ ) {
                var id = optList[n][props.id];
                opts += '<option value="' + id + '"';
                if (icon !== false && optList[n][icon].length > 0) {
                    opts += ' data-te-select-icon="' + optList[n][icon] + '"';
                }

                if ((multi !== false && optList[n][multi] == "on") ||
                    (single !== false && id == single)) opts += ' selected=""';

                opts += '>' + optList[n][props.label] + '</option>';
            }

            // Invoca l'handler all'interno dello script "inputs.js" che aggiunge o rimuove la classe
            // "no-content" all'input di mirror generato da tailwind e associato al <select>.
            // Nota: triggera solo l'handler in "inputs.js" senza invocare eventuali altri handler
            //       associati allo stesso <select> (tramite l'evento "change").
            $(selectQuery).html(opts).triggerHandler("select:update");

            updateSelectFilter(selectQuery);
        };

        var updateHierarchyBlocks = function(levels, sampleBlocks, levelBlocks, levelLangBlk,
                                             levelLangInputs, levelAdd, trashes, maxLevels) {
            var nLevels = levels.length;
            var nBlks = (nLevels > 1) ? nLevels : 1;

            // Abilita/disabilita il button di 'Add level'.
            (nLevels < maxLevels) ? $(levelAdd).removeClass("bt-disabled") :
                                    $(levelAdd).addClass("bt-disabled");

            // Visualizza/nascondi gli <input> di sample.
            var smblks = $(sampleBlocks);
            smblks.slice(0, nBlks).fadeIn("slow");
            smblks.slice(nBlks).fadeOut("slow");

            // Visualizza/nascondi l'icona di trash del primo livello.
            var lvlblks = $(levelBlocks);
            var trash = lvlblks.eq(0).find(trashes);
            (nLevels > 1) ? trash.fadeIn("slow") : trash.fadeOut("slow");

            // Triggera l'evento "hier-block-slide", questo provoca il trigger di 'eventName' per tutti
            // gli <input> del blocco visualizzato (slideDown), in questo modo, lo slideDown risulterà
            // più fluido (il trigger dell'evento focus nella funzione doInitInput() può infatti richiedere
            // diverso tempo e interferire con lo slideDown).
            var animation = function() {
                $(document).triggerHandler("hier-block-slide");
            };

            // Visualizza (primo statement) e nascondi (secondo statement) i blocchi dei livelli.
            lvlblks.slice(1, nBlks).slideDown("slow", animation).find("input.peer").prop("disabled", false);
            lvlblks.slice(nBlks).slideUp("slow").find("input.peer").prop("disabled", true);

            // Svuota preventivamente tutti gli <input>.
            var inps = lvlblks.find(levelLangBlk + " input.peer");
            inps.val("");

            // Imposta gli input di cui esiste una stringa nell'array levels.
            for ( var n = 0 ; n < nLevels ; n++ ) {
                // Determina gli <input> delle lingue del livello corrente e i dati disponibili
                // nel relativo livello nell'array levels.
                var langs = lvlblks.eq(n).find(levelLangBlk);
                var lvl = levels[n];

                // Itera le properties di levels[n] e imposta le stringhe presenti.
                for ( var i = 0 ; i < lvl.length ; i++ ) {
                    langs.find(levelLangInputs + (n + 1) + "-" + lvl[i].lang_code).val(lvl[i].name);
                }
            }

            // Aggiorna tutti gli <input>.
            lvlblks.slice(0, nBlks).find(levelLangBlk + " [data-te-input-wrapper-init]").each(function() {
                te.Input.getInstance(this).update();
            });
        };

        // Utility per la gestione del dialogBox modale di conferma.
        var openDeleteItemWarning = function(execButton, yesFunc) {
            $("#confirm-modal-title").text(execButton.data("delete-title"));  // Imposta il title del dialogBox.
            $("#confirm-modal-body").html(execButton.data("delete-body"));    // Imposta il testo del dialogBox.

            var dlg = $("#confirm-modal-dialogbox");
            var modal = new te.Modal(dlg.get(0));
            var yesBtn = $("#confirm-modal-yes-button");

            // Nota: i due handler ("click" e "hidden.te.modal") sono impostati con il metodo
            //       .one(), una volta invocati, viene automaticamente eseguito l'unbind.
            //       L'handler "click" è invocato solo se si preme il button "Yes".
            //       L'handler "hidden.te.modal" è invocato in ogni caso alla chiusura del
            //       dialogBox, se l'utente preme "No" (evento "hidden.te.modal"), è necessario
            //       rimuovere l'handler "click" tramite il metodo .off().
            //       La rimozione dell'handler dlg.off("hidden.te.modal") non è strettamente
            //       necessario se, appunto, l'utente preme il button "Yes".
            // Nota: è comunque necessario che ambedue gli handler siano unbounded dopo la
            //       chiusura del dialogBox in modo che possa essere riutilizzato da altre pagine.

            // Invocato premendo il button "Yes" del dialog "#confirm-modal-dialogbox".
            yesBtn.one("click", function(evt) {
                // Rimuovi l'handler dell'evento "hidden.te.modal" dal dialogBox
                // "#confirm-modal-dialogbox" e richiama la funzione da eseguire.
                dlg.off("hidden.te.modal");
                yesFunc();
            });

            // Invocato in ogni caso alla chiusura del dialogBox (se non si esegue l'unbound).
            dlg.one("hidden.te.modal", function() {
                // Rimuovi l'handler dell'evento "click" del button "#confirm-modal-yes-button"
                // nel caso il dialogBox sia chiuso tramite il button "No" o "Close".
                yesBtn.off("click");
            });

            // Visualizza il dialogBox modale di conferma.
            modal.show();
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Colore di background e testo per segnalare un errore.
        var bgError = "bg-red-100";
        var textError = "a4-text-dark-red";

        //////////////////////////////////////////////////////////////////////////////////
        // Determina se l'evento 'oninput' è supportato, in caso contrario, utilizza
        // l'evento 'onkeyup onchange oncut onpaste'.
        // Nota: queste due variabili vengono utilizzate in ogni blocco, crea un <input>
        //       temporaneo per eseguire il test.
        var eventName = ($("<input type=\"text\" />").prop("oninput") === undefined) ? "keyup" : "input";
        var eventAll = (eventName == "input") ? eventName : eventName + " change cut paste";


        //////////////////////////////////////////////////////////////////////////////////
        // Array(s), handler(s) e funzioni globali utilizzate da tutti i blocchi che
        // implementano il drag & drop (profile-block, customer-block e employees-block).

        // Array MIME types per i tipi di file supportati dal drag & drop.
        var acceptedImageMIMEs = ["image/gif", "image/jpeg", "image/png", "image/svg+xml"];

        // Previene il Drag & Drop nell'area del body del browser.
        $("body").on("dragenter dragleave dragover", function(evt) {
            // Questo statement previene il drop nel body del browser.
            evt.originalEvent.dataTransfer.dropEffect = "none";

            // Il metodo preventDefault() non è strettamente necessario.
            // NON invocare evt.stopPropagation() !!!
            evt.preventDefault();
        });

        // Determina se, tra le items in fase di dragenter dragleave dragover, c'è almeno un "file"
        // del tipo supportato (array acceptedImageMIMEs).
        var checkDropFileType = function(items) {
            // Itera la collection 'items' e determina se esiste almeno un "file" del tipo di
            // immagine supportata (vedi array globale acceptedImageMIMEs).
            if (items && items.length > 0) {
                for ( var n = 0; n < items.length ; n++ ) {
                    if (items[n].kind == "file" && acceptedImageMIMEs.indexOf(items[n].type) >= 0) return true;
                }
            }

            // Nessuna tra le items rappresenta un file supportato per il drag & drop.
            return false;
        };

        // Gestisce l'evento click dei link di navigazione nelle pagine di amministrazione.
        $(".menu-link").on("click", function(evt) {
            var link = $("#" + $(this).data("link-page"));
            link.triggerHandler("click");

            // Espandi il blocco (Profilo/Amministrazione) che contiene il link alla pagina target.
            var expandBlk = link.parent(".exp-block");
            if (expandBlk.is(":visible")) return;

            expandBlk.prev(".expander").triggerHandler("click");
        });

        // Reset degli eventuali file precedentemente selezionati con il dialogBox "Upload image".
        var resetInputFile = function(inputFile) {
            // Utilizza il metodo reset() del form, ma crea prima un form che racchiude l'input[type=file]
            // in modo da non modificare il resto dei campi, in seguito, esegui l'unwrap.
            inputFile.wrap("<form>").closest("form").get(0).reset();
            inputFile.unwrap();
        };

        // Aggiungi le classi "classes" a tutte le <option> del <select> "selObj".
        // Il parametro "teSel" è il DOM elements di "selObj".
        var addOptionClasses = function(teSel, selObj, classes) {
            // Applica un delay che permetta l'assestamento del <select>.
            window.setTimeout(function() {
                selObj.find("option").each(function(index) {
                    // Vedi properties del te.Select ("selects - te.Select.txt").
                    if (teSel._optionsToRender[index].node.className.indexOf(classes) < 0) {
                        teSel._optionsToRender[index].node.className += " " + classes;
                    }
                });
            }, 500);
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Gestione profile block.

        // Bind dell'handler per gli input "required".
        $("input#profile-firstname, input#profile-lastname, input#profile-email").on(eventAll, function(evt) {
            // Aggiorna lo stato di 'enabled' del button '#save-profile'.
            // Nota: l'input #profile-email è di tipo type="email" ed è validato automaticamente.
            var btnSave = $("#save-profile");

            var inpFirst = $("input#profile-firstname");
            var inpLast = $("input#profile-lastname");
            var inpEmail = $("input#profile-email");
            var bFirst = inpFirst.is(":valid");  // pattern="^\s*[a-zA-Z].*$".
            var bLast = inpLast.is(":valid");    // pattern="^\s*[a-zA-Z].*$".
            var bEmail = inpEmail.is(":valid");
            var bValid = bFirst && bLast && bEmail;

            inpFirst.prop("title", (bFirst) ? "" : inpFirst.data("title"));
            inpLast.prop("title", (bLast) ? "" : inpLast.data("title"));
            inpEmail.prop("title", (bEmail) ? "" : inpEmail.data("title"));

            if (bValid && btnSave.is(":disabled")) btnSave.prop("disabled", false);
            else if (!bValid && btnSave.is(":enabled")) btnSave.prop("disabled", true);
        }).triggerHandler(eventName);  // Trigger solo del primo elemento della collection.

        // Gestione button "Save" del form "profile-form".
        $("#save-profile").on("click", function(evt) {
            $("#profile-errors").addClass("hidden").html("");

            // Form-Data di invio.
            var formData = new window.FormData($("#profile-form").get(0));

            $.ajax({
                type: "post",
                url: "/admin.profile.store",
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    // Resetta i campi "password".
                    $("#profile-password, #profile-password-new").val("");
                    te.Input.getInstance($("#profile-password").parent("[data-te-input-wrapper-init]").get(0)).update();
                    te.Input.getInstance($("#profile-password-new").parent("[data-te-input-wrapper-init]").get(0)).update();

                    updateImpersonatingSelect();  // Aggiorna il <select#impersonated-employee>.
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#profile-errors"); }
            });
        });

        pageLoadCallbacks["load-profile-page"] = function() {
            $("#profile-errors").addClass("hidden").html("");

            $.ajax({
                type: "post",
                url: "/admin.profile.index",
                dataType: "json",
                data: { _token: $("#profile-form input[type=hidden][name=_token]").val() },  // Il token csrf è necessario.
                success: function(data, textStatus, jqXHR) {
                    var usr = data.user;
                    var blk = $("#profile-block");

                    // Itera i campi di tipo "input".
                    for (var key in usr) {
                        var field = blk.find("[data-te-input-wrapper-init] input.peer#" + key);
                        if (field.length > 0) {
                            var val = (usr[key] === null) ? "" : usr[key];
                            if (val === "" && field.data("nullable") === "yes") val = " ";


                            // Nota: a differenza di trigger(), il metodo triggerHandler() non ritorna
                            //       l'object jQuery con il quale è stato invocato, quindi non è possibile
                            //       estendere una 'chain call' con il ritorno di triggerHandler().
                            field.val(val);
                            te.Input.getInstance(field.parent("[data-te-input-wrapper-init]").get(0)).update();
                        }
                    }

                    var doTriggers = function() {
                        // Il metodo val() non triggera l'evento "input" (inputs.js), invoca esplicitamente l'handler
                        // per l'evento 'eventName' (all'occorrenza, al termine dello slideDown() della pagina corrente).
                        blk.find("[data-te-input-wrapper-init] input.peer").trigger(eventName);
                    };

                    if (blk.css("overflow") != "hidden") doTriggers();
                    else $(document).one("page-loaded:profile", doTriggers);

                    // Imposta il linguaggio preferenziale, il ruolo e la foto dell'utente.
                    te.Select.getInstance($("#profile-language-code").get(0)).setValue(usr["profile-language-code"]);
                    $("#profile-role").html("<option value=\"" + usr["profile-role"] + "\">" +
                                            usr["profile-role-label"] + "</option>");

                    // Visualizza la foto.
                    var photo = usr["profile-photo-image"];  // null se nessuna foto è presente.
                    var spn = $("#profile-photo-label").find("span");
                    var img = $("#profile-photo-image");
                    var del = $("#profile-photo-delete");
                    (photo) ? spn.addClass("hidden") : spn.removeClass("hidden");
                    (photo) ? img.prop("src", photo).removeClass("hidden").closest(".profile-image-box").removeClass("h-[250px] border-2") :
                              img.addClass("hidden").prop("src", "").closest(".profile-image-box").addClass("h-[250px] border-2");
                    (photo) ? del.removeClass("invisible") : del.addClass("invisible");
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#profile-errors"); }
            });
        };

        // Gestione button "Delete photo" del form "profile-form".
        $("#profile-photo-delete").on("click", function(evt) {
            $("#profile-errors").addClass("hidden").html("");

            $.ajax({
                type: "post",
                url: "/admin.profile.delete-photo",
                dataType: "json",
                data: { _token: $("#profile-form input[type=hidden][name=_token]").val() },  // Il token csrf è necessario.
                success: function(data, textStatus, jqXHR) {
                    $("#profile-photo-label").find("span").removeClass("hidden");
                    $("#profile-photo-image").addClass("hidden").prop("src", "")
                                             .closest(".profile-image-box").addClass("h-[250px] border-2");
                    $("#profile-photo-delete").addClass("invisible");

                    loadEmployeePhoto();  // Aggiorna la foto nella window del menu a sinistra.
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#profile-errors"); }
            });
        });

        //////////////////////////////////////////////////////////////////////////////////
        // Drag & Drop della foto del profile-block.

        // Array di oggetti Files ottenuti tramite Drag & Drop.
        var profileDroppedFiles = [];

        $("input#profile-photo[type=file]").each(function(index) {
            if (typeof(this.draggable) != "undefined") this.draggable = true;
        });

        $("input#profile-photo[type=file]").on("drop dragover dragenter", function(evt) {
            evt.preventDefault();
        });

        // Eventi Drag & Drop per il <div.profile-image-box>
        $("div.profile-image-box").on("dragenter dragleave dragover", function(evt) {
            // Il div è assunto come drop target (preventDefault()) se il drag contiene dei
            // files (types.contains("Files")).
            // Nota: non utilizzare il metodo includes() (dell'array types), non è standard e non
            //       è supportato da versioni vecchie di browser (IE, Opera 12.18, Safari 5.1.7).
            //       Utilizzare il metodo indexOf().
            evt.originalEvent.dataTransfer.dropEffect = "none";
            var types = evt.originalEvent.dataTransfer.types;

            if (types && types.indexOf("Files") >= 0 && checkDropFileType(evt.originalEvent.dataTransfer.items)) {
                evt.preventDefault();   // Non strettamente necessario.
                evt.stopPropagation();  // Necessario !!!
                evt.originalEvent.dataTransfer.dropEffect = "copy";

                var div = $(this);
                if (evt.type == "dragenter") div.addClass("drag-over");
                else if (evt.type == "dragleave") {
                    // Determina se il mouse si trova ancora nell'area del div.
                    // Nota: l'evento dragleave viene infatti generato anche quando il mouse
                    //       entra all'interno dell'immagine SVG e dello span che sono child
                    //       del div.
                    var offset = div.offset();
                    var w = div.outerWidth();
                    var h = div.outerHeight();
                    var b = evt.pageX >= offset.left && evt.pageX < (offset.left + w) &&
                            evt.pageY >= offset.top && evt.pageY < (offset.top + h);
                    if (!b) div.removeClass("drag-over");
                }
            }
        }).on("drop", function(evt) {  // Evento ondrop del div.
            evt.preventDefault();
            $(this).removeClass("drag-over");

            var files = evt.originalEvent.dataTransfer.files;
            if (files && files.length > 0) {
                // Reset dell'input#profile-photo[type=file].
                resetInputFile($("input#profile-photo[type=file]"));

                // Aggiungi i dropped file all'array profileDroppedFiles, se del tipo supportato.
                profileDroppedFiles = [];
                for ( var n = 0; n < files.length ; n++ ) {
                    if (acceptedImageMIMEs.indexOf(files[n].type) < 0) continue;

                    profileDroppedFiles.push(files[n]);
                }

                uploadProfilePhoto();
            }
        }).on("dragend dragexit", function(evt) {
            $(this).removeClass("drag-over");
        });

        // Gestione del button di selezione dell'attachment dell'immagine dell'utente.
        $("input#profile-photo[type=file]").on("change", function(evt) {
            var input = $(this);

            // Aggiungi i dropped file all'array profileDroppedFiles, se del tipo supportato.
            profileDroppedFiles = [];

            var files = input.prop("files");
            if (files !== undefined) {
                for ( var n = 0; n < files.length ; n++ ) {
                    if (acceptedImageMIMEs.indexOf(files[n].type) < 0) continue;

                    profileDroppedFiles.push(files[n]);
                }
            }

            uploadProfilePhoto();
        });

        // Carica immediatamente la foto dell'utente, invocato sia tramite drag&drop che tramite browse-file.
        var uploadProfilePhoto = function() {
            if (profileDroppedFiles.length <= 0) return;

            $("#profile-errors").addClass("hidden").html("");

            // Aggiungi al FormData il primo file immagine dell'array profileDroppedFiles.
            var formData = new window.FormData();
            formData.append("profilePhoto", profileDroppedFiles[0]);
            formData.append("_token", $("#profile-form input[type=hidden][name=_token]").val());  // Il token csrf è necessario.

            $.ajax({
                type: "post",
                url: "/admin.profile.upload-photo",
                dataType: "json",
                data: formData,
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    if (data.photo !== null) {
                        $("#profile-photo-label").find("span").addClass("hidden");
                        $("#profile-photo-image").prop("src", data.photo).removeClass("hidden")
                                                 .closest(".profile-image-box").removeClass("h-[250px] border-2");
                        $("#profile-photo-delete").removeClass("invisible");

                        loadEmployeePhoto();  // Aggiorna la foto nella window del menu a sinistra.
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#profile-errors"); }
            });
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Personal groups block.

        var validatePersonalGroup = function() {
            var bName = $("select#user-group-names").val() !== null;
            var grpInp = $("input#user-new-grp-name");
            var grpName = grpInp.val().trim().toLowerCase();
            var bNewName = grpName.length > 0, bNewDiff = true;

            $("select#user-group-names option").each(function() {
                // Determina se il new-name esiste già tra quelli nel <select#user-group-names>.
                if (grpName == $(this).text().toLowerCase()) return (bNewDiff = false);
            });

            var grpDOM = grpInp.get(0);
            grpInp.prop("title", grpInp.data((bNewDiff) ? "title" : "title-error"));
            if (grpDOM.setCustomValidity) grpDOM.setCustomValidity((bNewDiff) ? "" : "Error.");

            // Il metodo val() ritorna l'array dei value selezionati (<select multiple>).
            var bList = $("select#users-group-list").val().length > 0;

            var btnEdit = $("#edit-personal-group");
            var btnDelete = $("#delete-personal-group");
            var btnNew = $("#add-personal-group");

            // Il button "#delete-personal-group" è abilitato solo se la selezione del
            // <select#user-group-names> è valida.
            if (bName && btnDelete.is(":disabled")) btnDelete.prop("disabled", false);
            else if (!bName && btnDelete.is(":enabled")) btnDelete.prop("disabled", true);

            // Il button "#edit-personal-group" è abilitato solo se le selezioni dei
            // <select#user-group-names> e <select#users-group-list> sono valide, se
            // la stringa di <input#user-new-grp-name> è empty, allora rimarrà invariato
            // nel DB.
            if (bName && bList && btnEdit.is(":disabled")) btnEdit.prop("disabled", false);
            else if ((!bName || !bList) && btnEdit.is(":enabled")) btnEdit.prop("disabled", true);

            // Il button "#add-personal-group" è abilitato solo se la selezione del
            // <select#users-group-list> è valida, se la stringa di <input#user-new-grp-name>
            // NON è empty ed è diversa da qualsiasi nome presente nel <select#user-group-names>.
            if (bNewName && bNewDiff && bList && btnNew.is(":disabled")) btnNew.prop("disabled", false);
            else if ((!bNewName || !bNewDiff || !bList) && btnNew.is(":enabled")) btnNew.prop("disabled", true);
        };

        $("select#user-group-names").on("change", function(evt) {
            pageLoadCallbacks["load-personal-groups-page"]();
        });

        $("select#users-group-list").on("change", function(evt) {
            validatePersonalGroup();
        });

        $("input#user-new-grp-name").on(eventAll, function(evt) {
            validatePersonalGroup();
        });

        var personalGroupsActions = function(url) {
            $("#personal-groups-errors").addClass("hidden").html("");

            // Form-Data di invio.
            var formData = new window.FormData($("form#personal-groups-form").get(0));

            $.ajax({
                type: "post",
                url: url,
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    updateSelectOptions("#user-group-names", data.groups,
                                        { id: "id", label: "group_name", single: data.grpSel });
                    updateSelectOptions("#users-group-list", data.users,
                                        { id: "id", label: "fullname", icon: "photo_file", multi: "linked" })
                    validatePersonalGroup();
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#personal-groups-errors"); }
            });
        };

        // Gestione button "Modifica" del form "personal-groups-form".
        $("#edit-personal-group").on("click", function(evt) {
            personalGroupsActions("/admin.personal-groups.edit");
        });

        // Gestione button "Elimina" del form "personal-groups-form".
        $("#delete-personal-group").on("click", function(evt) {
            // Richiama la funzione di utility per la gestione del dialogBox modale di conferma.
            openDeleteItemWarning($(this),
                                  function() {
                                      personalGroupsActions("/admin.personal-groups.delete");
                                  });
        });

        // Gestione button "Nuovo" del form "personal-groups-form".
        $("#add-personal-group").on("click", function(evt) {
            personalGroupsActions("/admin.personal-groups.add");
        });

        pageLoadCallbacks["load-personal-groups-page"] = function() {
            personalGroupsActions("/admin.personal-groups.index");
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Personal job hierarchy block.

        const MAX_PHIER_BLOCKS = 4;

        // Gestione del button "Add" di un level di "Personal job hierarchy block".
        // Nota: i 4 blocchi massimi possibili sono già presenti nel DOM e devono essere
        //       semplicemente visualizzati.
        $("#phier-level-add").on("click", function(evt) {
            var container = $(".job-phier-container");
            if (container.length <= 0 || $(this).hasClass("bt-disabled")) return;

            var blks = container.find(".phier-blk");
            var id = blks.filter(":visible").length;

            if (id < MAX_PHIER_BLOCKS) {
                var blk = blks.eq(id);
                blk.find("input").val("").prop("disabled", false);  // Svuota gli input e abilitali.

                blk.slideDown("slow", function() {  // Visualizza il blocco.
                    validatePersonalJobHierarchy();
                });

                // Visualizza l'ultimo livello di sample.
                var sample = $("#phier-sample .phier-l").eq(id);
                sample.find("label[for^='phier-sample-l']").text("");
                sample.find("input[id^='phier-sample-l']").val("").attr({ "placeholder": "", "aria-label": "" });

                sample.fadeIn("slow");

                id++;
            }

            // Aggiorna i "notches" di tutti gli input del preview (le tre parti dell'input
            // a sinistra della label, la label stessa e a destra della label).
            $("#phier-sample [data-te-input-wrapper-init]").each(function() {
                te.Input.getInstance(this).update();
            });

            if (id >= MAX_PHIER_BLOCKS) $(this).addClass("bt-disabled");
            if (id >= 2) blks.eq(0).find(".phier-trash").fadeIn("slow");
        });

        // Gestione dei button per l'eliminazione dei livelli di gerarchia.
        $(".phier-trash").on("click", function(evt) {
            var blk = $(this).closest(".phier-blk");  // Blocco da eliminare.
            var blks = $(".job-phier-container").find(".phier-blk");
            var idEnd = blks.filter(":visible").length - 1;

            var idStart = blks.index(blk);
            if (idStart < 0 || idEnd <= 0) return;

            // Sposta di una posizione indietro i valori degli input seguenti al blocco da eliminare.
            for ( var n = idStart; n < idEnd ; n++ ) {
                var inpDst = blks.eq(n).find("input");
                var inpSrc = blks.eq(n + 1).find("input");

                // Imposta il nuovo testo di ogni <input>.
                for ( var i = 0; i < inpDst.length; i++ ) inpDst.eq(i).val(inpSrc.eq(i).val());
            }

            blk = blks.eq(idEnd);
            blk.find("input").val("").prop("disabled", true);

            // Aggiorna i "notches" di tutti gli input del preview e dei livelli (le tre parti
            // dell'input: a sinistra della label, la label stessa e a destra della label).
            $("#phier-sample [data-te-input-wrapper-init]").each(function() {
                te.Input.getInstance(this).update();
            });
            blks.find("[data-te-input-wrapper-init]").each(function() {
                te.Input.getInstance(this).update();
            });

            blk.slideUp("slow", function() {  // Nascondi il blocco.
                var ln = blks.filter(":visible").length;
                if (ln < MAX_PHIER_BLOCKS) $("#phier-level-add").removeClass("bt-disabled");
                if (idEnd <= 1) blks.eq(0).find(".phier-trash").fadeOut("fast");

                updatePersonalJobHierarchySamples();
                validatePersonalJobHierarchy();

                blks.find("input.peer").trigger(eventName);  // Trigger di tutti gli elementi <input.peer>.
            });

            // Nascondi l'ultimo livello di sample.
            $("#phier-sample .phier-l").eq(idEnd).fadeOut("slow");
        });

        $(".phier-blk.collapse").css("display", "none").removeClass("collapse h-0").addClass("mt-4 px-4 pt-3 pb-4");

        // Preimposta la visibilità dell'icona di trash del primo blocco.
        var n = $(".job-phier-container").find(".phier-blk").filter(":visible").length;
        if (n <= 1) $(".job-phier-container").find(".phier-blk").eq(0).find(".phier-trash").fadeOut("fast");

        var validatePersonalJobHierarchy = function() {
            var bName = $("select#personal-job-hierarchy-names").val() !== null;
            var hierInp = $("input#personal-new-job-hierarchy-name");
            var hierName = hierInp.val().trim().toLowerCase();
            var bNewName = hierName.length > 0, bNewDiff = true;

            $("select#personal-job-hierarchy-names option").each(function() {
                // Determina se il new-name esiste già tra quelli nel <select#personal-job-hierarchy-names>.
                if (hierName == $(this).text().toLowerCase()) return (bNewDiff = false);
            });
            var hierDOM = hierInp.get(0);
            hierInp.prop("title", hierInp.data((bNewDiff) ? "title" : "title-error"));
            if (hierDOM.setCustomValidity) hierDOM.setCustomValidity((bNewDiff) ? "" : "Error.");

            // Per ogni livello di gerarchia deve esserci almeno un nome valido (in una qualsiasi lingua).
            var bLevels = true;
            $(".job-phier-container").find(".phier-blk").filter(":visible").each(function(index) {
                var bLvl = false;
                var blk = $(this);

                // Itera gli <input> delle lingue del livello corrente.
                blk.find(".phier-langs input[name^='phier-']").each(function() {
                    if ($(this).val().trim().length > 0) {
                        bLvl = true;
                        return false;  // Termina l'iterazione di each().
                    }
                });

                if (!bLvl) {
                    bLevels = false;
                    blk.prop("title", blk.data("title"));
                    blk.addClass(bgError).find(".phier-level span").addClass(textError);
                }
                else {
                    blk.prop("title", "");
                    blk.removeClass(bgError).find(".phier-level span").removeClass(textError);
                }
            });

            var btnEdit = $("#edit-personal-job-hierarchy");
            var btnDelete = $("#delete-personal-job-hierarchy");
            var btnNew = $("#add-personal-job-hierarchy");

            // Il button "#delete-personal-job-hierarchy" è abilitato solo se la selezione del
            // <select#personal-job-hierarchy-names> è valida.
            if (bName && btnDelete.is(":disabled")) btnDelete.prop("disabled", false);
            else if (!bName && btnDelete.is(":enabled")) btnDelete.prop("disabled", true);

            // Il button "#edit-personal-job-hierarchy" è abilitato solo se la selezione di
            // <select#personal-job-hierarchy-names> è valida e, per ogni livello di gerarchia,
            // c'è almeno un nome valido (in una qualsiasi lingua).
            // Se la stringa di <input#personal-new-job-hierarchy-name> è empty, allora rimarrà
            // invariato nel DB.
            if (bName && bLevels && btnEdit.is(":disabled")) btnEdit.prop("disabled", false);
            else if ((!bName || !bLevels) && btnEdit.is(":enabled")) btnEdit.prop("disabled", true);

            // Il button "#add-personal-job-hierarchy" è abilitato solo se, per ogni livello di
            // gerarchia, c'è almeno un nome valido (in una qualsiasi lingua) e se la stringa di
            // <input#personal-new-job-hierarchy-name> NON è empty.
            if (bNewName && bNewDiff && bLevels && btnNew.is(":disabled")) btnNew.prop("disabled", false);
            else if ((!bNewName || !bNewDiff || !bLevels) && btnNew.is(":enabled")) btnNew.prop("disabled", true);
        };

        $("select#personal-job-hierarchy-names").on("change", function(evt) {
            pageLoadCallbacks["load-personal-job-hierarchy-page"]();
        });

        $("input#personal-new-job-hierarchy-name").on(eventAll, function(evt) {
            validatePersonalJobHierarchy();
        });

        // Aggiorna le label dei sample dei livelli.
        var updatePersonalJobHierarchySamples = function() {
            // Itera i blocchi dei livelli visibili.
            $(".job-phier-container").find(".phier-blk").filter(":visible").each(function(index) {
                var strLabel = "";

                // Itera gli <input> delle lingue del livello corrente.
                $(this).find(".phier-langs input[name^='phier-']").each(function() {
                    // Estrai il codice della lingua dell'<input> corrente.
                    var lng = (/^phier-\d+-([a-z]{2})$/.exec($(this).prop("id")))[1];
                    var str = $(this).val().trim();

                    if (str.length > 0) {
                        // Imposta il testo della prima lingua non empty come label
                        // del sample del livello corrente.
                        // Non sovrascrivere la prima stringa trovata, non è sicuro che ci sia una
                        // label valida anche per la lingua corrente.
                        if (strLabel.length <= 0) strLabel = str;

                        // Se la lingua dell'<input> corrente è quella di default, termina il ciclo
                        // e assumi la stringa della variabile 'str' come label.
                        if (lng == currentLanguage) {
                            strLabel = str;
                            return false;  // Termina l'iterazione di each().
                        }
                    }
                });

                // Blocco del livello corrente.
                var blk = $("#phier-sample .phier-l").eq(index);
                var inp = blk.find("input[id^='phier-sample-l']");
                blk.find("label[for^='phier-sample-l']").text(strLabel);
                inp.attr({ "placeholder": strLabel, "aria-label": strLabel });

                // Aggiorna i "notches" dell'input corrente (le tre parti dell'input: a sinistra
                // della label, la label stessa e a destra della label).
                te.Input.getInstance(blk.get(0)).update();
            });
        };

        $(".phier-langs input[name^='phier-']").on(eventAll, function(evt) {
            updatePersonalJobHierarchySamples();
            validatePersonalJobHierarchy();
        });

        var personalHierarchyActions = function(url) {
            $("#personal-job-hierarchy-errors").addClass("hidden").html("");

            // Form-Data di invio.
            var formData = new window.FormData($("form#personal-job-hierarchy-form").get(0));

            $.ajax({
                type: "post",
                url: url,
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    updateSelectOptions("#personal-job-hierarchy-names", data.hierarchies,
                                        { id: "id", label: "name", single: data.hierarchySel });
                    updateHierarchyBlocks(data.levels, "#phier-sample .phier-l", ".job-phier-container .phier-blk",
                                          ".phier-langs", "#phier-", "#phier-level-add", ".phier-trash", MAX_PHIER_BLOCKS);
                    updatePersonalJobHierarchySamples();
                    validatePersonalJobHierarchy();

                    var doTriggers = function() {
                        // Il metodo val() non triggera l'evento "input" (inputs.js), invoca esplicitamente l'handler
                        // per l'evento 'eventName' (all'occorrenza, al termine dello slideDown() della pagina corrente).
                        $("#personal-job-hierarchy-block [data-te-input-wrapper-init] input.peer").trigger(eventName);
                    };

                    if ($("#personal-job-hierarchy-block").css("overflow") != "hidden") $(document).one("hier-block-slide", doTriggers);
                    else $(document).one("page-loaded:personal-job-hierarchy", doTriggers);
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#personal-job-hierarchy-errors"); }
            });
        };

        // Gestione button "Modifica" del form "personal-job-hierarchy-form".
        $("#edit-personal-job-hierarchy").on("click", function(evt) {
            $("#phier-level-count").val($(".job-phier-container .phier-blk:visible").length);
            personalHierarchyActions("/admin.personal-job-hierarchy.edit");
        });

        // Gestione button "Elimina" del form "personal-job-hierarchy-form".
        $("#delete-personal-job-hierarchy").on("click", function(evt) {
            // Richiama la funzione di utility per la gestione del dialogBox modale di conferma.
            openDeleteItemWarning($(this),
                                  function() {
                                      personalHierarchyActions("/admin.personal-job-hierarchy.delete");
                                  });
        });

        // Gestione button "Nuovo" del form "personal-job-hierarchy-form".
        $("#add-personal-job-hierarchy").on("click", function(evt) {
            $("#phier-level-count").val($(".job-phier-container .phier-blk:visible").length);
            personalHierarchyActions("/admin.personal-job-hierarchy.add");
        });

        pageLoadCallbacks["load-personal-job-hierarchy-page"] = function() {
            personalHierarchyActions("/admin.personal-job-hierarchy.index");
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Customer block.

        var customerToolsOneTime = function() {
            // Il metodo .one(), che utilizza questa funzione, esegue l'unbind dell'evento
            // "show.te.dropdown" dopo la prima volta che viene aperto il dropdown
            // "#dropdown-customer-tools".
            // Inizializza tutti i <select.cust-tool-selector> ed esegui il bind
            // dell'evento "open.te.select" per tutti i <select.cust-tool-selector>.

            // Itera tutti i <select.cust-tool-selector>.
            $("select.cust-tool-selector").each(function() {
                var sel = $(this);
                var wrapper = sel.closest("[data-te-select-wrapper-ref]");
                var outline = wrapper.find("[data-te-select-form-outline-ref]");

                // Imposta la classe effettiva della label relativa all'impostazione dei ogni <select.cust-tool-selector>.
                var vl = sel.find("option:selected").val();
                sel.closest(".select-sm-cont").next("div").removeClass("tool-yes tool-no tool-disabled")
                                                          .addClass("tool-" + vl);

                wrapper.addClass("w-11");
                var inp = outline.find("input[data-te-select-input-ref]");
                inp.removeClass("pl-3 pr-8").addClass("pl-1.5 pr-5");
                outline.find("span.absolute").removeClass("w-5 h-5 right-3").addClass("w-4 h-4 right-1");

                // Quando il dropdown del <select> sta per essere aperto, inizializzalo.
                // Nota: il dropdown del <select> viene creato all'apertura e distrutto alla chiusura,
                //       quindi l'inizializzazione va fatta ad ogni apertura.
                sel.on("open.te.select", function(evt) {
                    var _sel = $(this);  // Closure di 'sel' utilizzata all'interno di setTimeout().

                    // Ritarda l'inizializzazione per dare il tempo al dropdown di essere creato.
                    // Nota: purtroppo non esiste l'evento triggerato DOPO che il dropdown è stato creato.
                    window.setTimeout(function() {
                        var container = $("div[data-te-select-dropdown-container-ref]");
                        var dropdown = container.find("div[data-te-select-dropdown-ref]");
                        var cls = /\b(min-w-\S+)/.exec(dropdown.prop("className"));
                        if (cls !== null) dropdown.removeClass(cls[1]);

                        dropdown.find("div[data-te-select-options-wrapper-ref]").on("click", function(evt) {
                            // Evita che il dropdown dei tools ("#dropdown-customer-tools") si chiuda
                            // quando viene chiuso il dropdown di un <select.cust-tool-selector>.
                            evt.stopPropagation();
                        });

                        // Copia i tooltip delle <option> dei <select.cust-tool-selector> nel rispettivi
                        // dropdown creati dinamicamente da tw-elements.
                        var items = dropdown.find("div[data-te-select-option-ref]");
                        var opts = _sel.find("option");
                        items.each(function(index) {
                            $(this).prop("title", opts.eq(index).prop("title"));
                        }).addClass("text-xs").find("span[data-te-select-option-text-ref]").addClass("mx-auto");

                        cls = /\b(px-\S+)/.exec(items.prop("className"));
                        if (cls !== null) items.removeClass(cls[1]);
                    }, 20);
                }).on("change", function(evt) {
                    // Il tooltip della <option> selezionata è già copiata nell'<input> del <select> dallo script "inputs.js".
                    var vl = $(this).find("option:selected").val();
                    $(this).closest(".select-sm-cont").next("div").removeClass("tool-yes tool-no tool-disabled")
                                                                  .addClass("tool-" + vl);
                });
            });
        };

        // Bind dell'handler per l'input "required".
        $("input#customer-name").on(eventAll, function(evt) {
            // Aggiorna lo stato di 'enabled' del button '#save-customer'.
            var btnSave = $("#save-customer");

            var inpName = $("input#customer-name");
            var bValid = inpName.is(":valid");  // pattern="^\s*[a-zA-Z].*$".
            inpName.prop("title", (bValid) ? "" : inpName.data("title"));

            if (bValid && btnSave.is(":disabled")) btnSave.prop("disabled", false);
            else if (!bValid && btnSave.is(":enabled")) btnSave.prop("disabled", true);
        }).triggerHandler(eventName);

        $("#customer-country").on("change", function(evt) {
            if ($(this).val().length > 0) {
                $("#customer-errors").addClass("hidden").html("");

                // Form-Data di invio.
                var formData = new window.FormData($("form#customer-form").get(0));

                $.ajax({
                    type: "post",
                    url: "/admin.customer.change-country",
                    dataType: "json",
                    data: formData,      // Il token csrf è già incluso nel formData.
                    processData: false,  // tell jQuery not to process the data.
                    contentType: false,  // tell jQuery not to set contentType.
                    success: function(data, textStatus, jqXHR) {
                        // Popola la lista degli stati.
                        $("#customer-country-state").html(data.states)
                                                    .prop("disabled", data.states.length <= 0)
                                                    .triggerHandler("select:update");
                        updateSelectFilter("#customer-country-state");
                    },
                    error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#customer-errors"); }
                });
            }
            else $("#customer-country-state").html("").prop("disabled", true).triggerHandler("select:update");
        });

        // Gestione button "Save" del form "customer-form".
        $("#save-customer").on("click", function(evt) {
            // Controlla se si stanno per salvare delle impostazioni che eliminano delle entries
            // della tabella `customer_tool`, se l'eliminazione di almeno una di queste entries
            // provoca anche l'eliminazione di relativi 'job' (ON DELETE CASCADE), chiedi conferma.
            var lbl = $("#dropdown-customer-tools").next("ul").find(".select-sm-cont").next("div");
            var warnList = lbl.filter(".tool-no[data-have-jobs]");
            if (warnList.length > 0) {
                var list = "";
                warnList.each(function(index) {
                    if (index > 0) list += "<br />";
                    list += $(this).prop("title");
                });

                $("#customer-tool-warning [data-te-modal-body-ref] .warning-list").html(list);
                (new te.Modal($("#customer-tool-warning").get(0))).show();
            }
            else $("#close-tool-warning").triggerHandler("click");
        });
        $("#close-tool-warning").on("click", function(evt) {  // Button di "Save" nel dialogBox modale "#dropdown-customer-tools".
            $("#customer-errors").addClass("hidden").html("");

            // Form-Data di invio.
            var formData = new window.FormData($("#customer-form").get(0));

            $.ajax({
                type: "post",
                url: "/admin.customer.store",
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    $("#customer-errors").addClass("hidden").html("");

                    // data("job-count") => '{0} (Nessun job)|{1} (1 job)|[2,*] (:count jobs)'  (nella lingua corrente).
                    // jobCount array:
                    //   [1]: ' (Nessun job)'
                    //   [2]: ' (1 job)'
                    //   [3]: ' (:count jobs)'
                    var jobCount = /( \([^\)]+\)).+( \([^\)]+\)).+( \([^\)]+\))/.exec($("#customer-tools-block").data("job-count"));

                    // Aggiorna lo stato di bold e il tooltip di ogni stato di assegnazione dei tools.
                    for (var tool of data.tools) {
                        var dv = $("div#tool-label-" + tool.id);
                        (tool.enabled !== null) ? dv.addClass("font-bold") : dv.removeClass("font-bold");

                        // Formatta il numero di jobs: [1] = ' (Nessun job), [2] = ' (1 job)', [3] = ' (:count jobs)'.
                        var jobTooltip = jobCount[(tool.cntJobs > 1) ? 3 : ((tool.cntJobs == 1) ? 2 : 1)];
                        jobTooltip = jobTooltip.replace(/:count/, tool.cntJobs);  // sostituisce il placeholder :count (se esiste).
                        dv.prop("title", tool.name_id + "." + tool.title_id + jobTooltip);
                    }

                    updateImpersonatingSelect();  // Aggiorna il <select#impersonated-employee>.
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#customer-errors"); }
            });
        });

        pageLoadCallbacks["load-customer-page"] = function() {
            $("#customer-errors").addClass("hidden").html("");

            // Form-Data di invio.
            var formData = new window.FormData($("form#customer-form").get(0));

            $.ajax({
                type: "post",
                url: "/admin.customer.index",
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    var cust = data.customer;

                    var fields = ["customer-name", "customer-company-uid", "customer-address1",
                                  "customer-address2", "customer-city", "customer-zip", "customer-vat"];
                    var blk = $("#customer-block");
                    blk.find("#customer-customer-name").text(cust["customer-name"]);

                    // Imposta il select del numero degli users.
                    var selUsers = blk.find("#customer-number-users");
                    var teSel = te.Select.getInstance(selUsers.get(0));
                    var nUsersId = (cust["customer-number-users"] === null) ? 0 : cust["customer-number-users"];
                    teSel.setValue(nUsersId);
                    if (nUsersId == 0) selUsers.triggerHandler("select:update");

                    // Visualizza il logo.
                    var logo = cust["customer-logo-image"];  // null se nessun logo è presente.
                    var spn = $("#customer-logo-label").find("span");
                    var img = $("#customer-logo-image");
                    var del = $("#customer-logo-delete");
                    (logo) ? spn.addClass("hidden") : spn.removeClass("hidden");
                    (logo) ? img.prop("src", logo).removeClass("hidden").closest(".customer-image-box").removeClass("border-2") :
                             img.addClass("hidden").prop("src", "").closest(".customer-image-box").addClass("border-2");

                    // Utilizza "visibility: hidden" per riservare lo spazio occupato della prima colonna (grid-cols-[1.75rem_1fr]).
                    (logo) ? del.removeClass("invisible") : del.addClass("invisible");

                    var admin = data.admin;

                    var loadLazyData = function() {
                        // Itera i campi di tipo "input".
                        for (var name of fields) {
                            var field = blk.find("[data-te-input-wrapper-init] input.peer#" + name);
                            var val = cust[name] ?? "";
                            field.val(val);
                            te.Input.getInstance(field.parent("[data-te-input-wrapper-init]").get(0)).update();
                        }

                        // Il metodo val() non triggera l'evento "input" (inputs.js), invoca esplicitamente l'handler
                        // per l'evento 'eventName' (all'occorrenza, al termine dello slideDown() della pagina corrente).
                        blk.find("[data-te-input-wrapper-init] input.peer").trigger(eventName);

                        // Popola la lista di nazioni.
                        var countries = $("#customer-country");
                        if ($("#country-loaded").val() == "no") {
                            countries.html(data.countries).triggerHandler("select:update");
                            updateSelectFilter("#customer-country");
                            $("#country-loaded").val("yes");
                        }
                        else if (data.newCountryId.length > 0) {
                            te.Select.getInstance(countries.get(0)).setValue(data.newCountryId);
                        }

                        if (data.states.length > 0) {
                            // Popola la lista degli stati.
                            $("#customer-country-state").html(data.states)
                                                        .prop("disabled", data.states.length <= 0)
                                                        .triggerHandler("select:update");
                            updateSelectFilter("#customer-country-state");
                        }
                        else if (data.newStateId != 0) {
                            // Il value da selezionare deve essere una stringa (converti da integer a string).
                            te.Select.getInstance($("#customer-country-state").get(0)).setValue(data.newStateId + "");
                        }

                        // Imposta i dati di super-admin (se presenti).
                        if (typeof(admin["customer-type"]) == "undefined") return;

                        // Itera i tools (lazy-load).
                        var toolLines = "";
                        var dropdown = $("#customer-tools-block");

                        // data("job-count") => '{0} (Nessun job)|{1} (1 job)|[2,*] (:count jobs)'  (nella lingua corrente).
                        // jobCount array:
                        //   [1]: ' (Nessun job)'
                        //   [2]: ' (1 job)'
                        //   [3]: ' (:count jobs)'
                        var jobCount = /( \([^\)]+\)).+( \([^\)]+\)).+( \([^\)]+\))/.exec(dropdown.data("job-count"));
                        var toolColl = admin["customer-tools"];

                        for (var tool of toolColl) {
                            toolLines += "<li class=\"p-2 hover:bg-neutral-100\">" +
                                        "<div class=\"grid grid-cols-[auto_1fr] gap-x-1\">" +
                                            "<div class=\"select-sm-cont flex justify-start text-sm\">";
                            var nameId = tool.name_id.toLowerCase();
                            toolLines += "<select id=\"cust-tool-" + nameId + "\" name=\"cust-tool-" + nameId;
                            toolLines += "\" data-te-select-init=\"\" data-te-select-size=\"sm\" ";
                            toolLines += "data-te-class-select-input-size-sm=\"py-[0.2rem] text-xs leading-[1.5]\" ";
                            toolLines += "data-te-select-option-height=\"30\" class=\"cust-tool-selector\">";

                            // Imposta le <option>.
                            var sel = (tool.enabled === "Y") ? " selected" : "";
                            toolLines += "<option value=\"yes\" title=\"" + dropdown.data("assigned-tooltip") + "\"" + sel + ">" + dropdown.data("assigned") + "</option>";
                            sel = (tool.enabled === null) ? " selected" : "";
                            toolLines += "<option value=\"no\" title=\"" + dropdown.data("unassigned-tooltip") + "\"" + sel + ">" + dropdown.data("unassigned") + "</option>";
                            sel = (tool.enabled === "N") ? " selected" : "";
                            toolLines += "<option value=\"disabled\" title=\"" + dropdown.data("disabled-tooltip") + "\"" + sel + ">" + dropdown.data("disabled") + "</option>";

                            toolLines += "</select></div><div id=\"tool-label-" + tool.id + "\" class=\"tool-access-div\"";

                            // Formatta il numero di jobs: [1] = ' (Nessun job), [2] = ' (1 job)', [3] = ' (:count jobs)'.
                            var jobTooltip = jobCount[(tool.cntJobs > 1) ? 3 : ((tool.cntJobs == 1) ? 2 : 1)];
                            jobTooltip = jobTooltip.replace(/:count/, tool.cntJobs);  // sostituisce il placeholder :count (se esiste).
                            toolLines += " title=\"" + tool.name_id + "." + tool.title_id + jobTooltip + "\"";
                            if (tool.cntJobs > 0) toolLines += " data-have-jobs=\"" + tool.cntJobs + "\"";

                            // Se il tool corrente ha dei jobs, rendi visibile il bullet ■, altrimenti, rendilo trasparente ("tool-have-no-job").
                            var haveJobs = "<span class=\"";
                            haveJobs += (tool.cntJobs > 0) ? "tool-have-job" : "tool-have-no-job";
                            toolLines += ">" + haveJobs + "\">&#x25a0;</span><span";
                            if (tool.enabled !== null) toolLines += " class=\"underline\"";  // applica lo stile underline se il tool non è 'unassigned'.
                            toolLines += ">" + tool.name_id + "." + tool.title_id + "</span></div></div></li>";
                        }

                        // Ottieni le due funzioni di inizializzazione dinamica (se non lo sono già).
                        getInitFuncs();

                        // Popola il dropdown dei tools ed inizializza tutti i rispettivi <select> di stato.
                        $("#customer-tools-dropdown").html(toolLines)
                                                     .find(".cust-tool-selector").each(function() {
                            new te.Select(this);    // Inizializza il <select>.
                            fnInitSelect($(this));  // Attach degli eventi custom e personalizzazione del <select>.
                        });

                        // Imposta l'handler one-time dopo che il nuovo contenuto impostato con il metodo
                        // .html() ha distrutto gli handler impostati internamente al suo interno.
                        $("#dropdown-customer-tools").one("show.te.dropdown", customerToolsOneTime);
                    }

                    // Se la pagina "Customer" è completamente aperta, esegui il caricamento delle nazioni, stati e
                    // tools, altrimenti, attendi che la pagina sia completamente aperta (evento "page-loaded:customer").
                    if (blk.css("overflow") != "hidden") loadLazyData();
                    // Il fadeOut viene eseguito in animateScroll() o nell'handler $(".exp-block .admin-selector").on("click").
                    else $(document).one("page-loaded:customer", loadLazyData);

                    // Imposta i <select> "customer-type", "customer-status" e "customer-use-saml".
                    var selType = $("#customer-type");
                    var isAdmin = admin["customer-type"].indexOf("siteOwner") > 0;
                    selType.html(admin["customer-type"]);
                    selType.prop("disabled", isAdmin);

                    var selStatus = $("#customer-status");
                    selStatus.html(admin["customer-status"]);
                    selStatus.prop("disabled", isAdmin);

                    te.Select.getInstance($("#customer-use-saml").get(0)).setValue(admin["customer-use-saml"]);
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#customer-errors"); }
            });
        };

        // Gestione button "Delete logo" del form "customer-form".
        $("#customer-logo-delete ").on("click", function(evt) {
            $("#customer-errors").addClass("hidden").html("");

            $.ajax({
                type: "post",
                url: "/admin.customer.delete-logo",
                dataType: "json",
                data: { _token: $("#customer-form input[type=hidden][name=_token]").val() },  // Il token csrf è necessario.
                success: function(data, textStatus, jqXHR) {
                    $("#customer-logo-label").find("span").removeClass("hidden");
                    $("#customer-logo-image").addClass("hidden").prop("src", "")
                                             .closest(".customer-image-box").addClass("border-2");
                    $("#customer-logo-delete").addClass("invisible");
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#customer-errors"); }
            });
        });


        //////////////////////////////////////////////////////////////////////////////////
        // Drag & Drop della foto del customer-block.

        // Array di oggetti Files ottenuti tramite Drag & Drop.
        var customerDroppedFiles = [];

        $("input#customer-logo[type=file]").each(function(index) {
            if (typeof(this.draggable) != "undefined") this.draggable = true;
        });

        $("input#customer-logo[type=file]").on("drop dragover dragenter", function(evt) {
            evt.preventDefault();
        });

        // Eventi Drag & Drop per il <div.customer-image-box>
        $("div.customer-image-box").on("dragenter dragleave dragover", function(evt) {
            // Il div è assunto come drop target (preventDefault()) se il drag contiene dei
            // files (types.contains("Files")).
            // Nota: non utilizzare il metodo includes() (dell'array types), non è standard e non
            //       è supportato da versioni vecchie di browser (IE, Opera 12.18, Safari 5.1.7).
            //       Utilizzare il metodo indexOf().
            evt.originalEvent.dataTransfer.dropEffect = "none";
            var types = evt.originalEvent.dataTransfer.types;

            if (types && types.indexOf("Files") >= 0 && checkDropFileType(evt.originalEvent.dataTransfer.items)) {
                evt.preventDefault();   // Non strettamente necessario.
                evt.stopPropagation();  // Necessario !!!
                evt.originalEvent.dataTransfer.dropEffect = "copy";

                var div = $(this);
                if (evt.type == "dragenter") div.addClass("drag-over");
                else if (evt.type == "dragleave") {
                    // Determina se il mouse si trova ancora nell'area del div.
                    // Nota: l'evento dragleave viene infatti generato anche quando il mouse
                    //       entra all'interno dell'immagine SVG e dello span che sono child
                    //       del div.
                    var offset = div.offset();
                    var w = div.outerWidth();
                    var h = div.outerHeight();
                    var b = evt.pageX >= offset.left && evt.pageX < (offset.left + w) &&
                            evt.pageY >= offset.top && evt.pageY < (offset.top + h);
                    if (!b) div.removeClass("drag-over");
                }
            }
        }).on("drop", function(evt) {  // Evento ondrop del div.
            evt.preventDefault();
            $(this).removeClass("drag-over");

            var files = evt.originalEvent.dataTransfer.files;
            if (files && files.length > 0) {
                // Reset dell'input#customer-logo[type=file].
                resetInputFile($("input#customer-logo[type=file]"));

                // Aggiungi i dropped file all'array customerDroppedFiles, se del tipo supportato.
                customerDroppedFiles = [];
                for ( var n = 0; n < files.length ; n++ ) {
                    if (acceptedImageMIMEs.indexOf(files[n].type) < 0) continue;

                    customerDroppedFiles.push(files[n]);
                }

                uploadCustomerLogo();
            }
        }).on("dragend dragexit", function(evt) {
            $(this).removeClass("drag-over");
        });

        // Gestione del button di selezione dell'attachment dell'immagine dell'utente.
        $("input#customer-logo[type=file]").on("change", function(evt) {
            var input = $(this);

            // Aggiungi i dropped file all'array customerDroppedFiles, se del tipo supportato.
            customerDroppedFiles = [];

            var files = input.prop("files");
            if (files !== undefined) {
                for ( var n = 0; n < files.length ; n++ ) {
                    if (acceptedImageMIMEs.indexOf(files[n].type) < 0) continue;

                    customerDroppedFiles.push(files[n]);
                }
            }

            uploadCustomerLogo();
        });

        // Carica immediatamente il logo del customer, invocato sia tramite drag&drop che tramite browse-file.
        var uploadCustomerLogo = function() {
            if (customerDroppedFiles.length <= 0) return;

            $("#customer-errors").addClass("hidden").html("");

            // Aggiungi al FormData il primo file immagine dell'array customerDroppedFiles.
            var formData = new window.FormData();
            formData.append("customerLogo", customerDroppedFiles[0]);
            formData.append("_token", $("#customer-form input[type=hidden][name=_token]").val());  // Il token csrf è necessario.

            $.ajax({
                type: "post",
                url: "/admin.customer.upload-logo",
                dataType: "json",
                data: formData,
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    if (data.logo !== null) {
                        $("#customer-logo-label").find("span").addClass("hidden");
                        $("#customer-logo-image").prop("src", data.logo).removeClass("hidden")
                                                 .closest(".customer-image-box").removeClass("border-2");
                        $("#customer-logo-delete").removeClass("invisible");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#customer-errors"); }
            });
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Customer contacts block.

        var validateContacts = function() {
            var bName = $("select#customer-contact-names").val() !== null;

            var inpFirst = $("input#contact-firstname");
            var inpLast = $("input#contact-lastname");
            var inpEmail = $("input#contact-email");
            var bFirst = inpFirst.is(":valid");  // pattern="^\s*[a-zA-Z].*$".
            var bLast = inpLast.is(":valid");    // pattern="^\s*[a-zA-Z].*$".
            var bEmail = inpEmail.is(":valid");
            var bValid = bFirst && bLast && bEmail;

            inpFirst.prop("title", (bFirst) ? "" : inpFirst.data("title"));
            inpLast.prop("title", (bLast) ? "" : inpLast.data("title"));
            inpEmail.prop("title", (bEmail) ? "" : inpEmail.data("title"));

            var btnEdit = $("#edit-customer-contact");
            var btnDelete = $("#delete-customer-contact");
            var btnNew = $("#add-customer-contact");

            // Il button "#delete-customer-contact" è abilitato solo se la selezione del
            // <select#customer-contact-names> è valida.
            if (bName && btnDelete.is(":disabled")) btnDelete.prop("disabled", false);
            else if (!bName && btnDelete.is(":enabled")) btnDelete.prop("disabled", true);

            // Il button "#edit-customer-contact" è abilitato solo se la selezione di
            // <select#customer-contact-names> e i tre field 'required' sono validi.
            if (bName && bValid && btnEdit.is(":disabled")) btnEdit.prop("disabled", false);
            else if ((!bName || !bValid) && btnEdit.is(":enabled")) btnEdit.prop("disabled", true);

            // Il button "#add-customer-contact" è abilitato solo se i tre campi required sono validi.
            if (bValid && btnNew.is(":disabled")) btnNew.prop("disabled", false);
            else if (!bValid && btnNew.is(":enabled")) btnNew.prop("disabled", true);
        };

        $("select#customer-contact-names").on("change", function(evt) {
            pageLoadCallbacks["load-customer-contacts-page"]();
        });

        $("input#contact-firstname, input#contact-lastname, input#contact-email").on(eventAll, function(evt) {
            validateContacts();
        }).triggerHandler(eventName);  // Trigger solo del primo elemento della collection.

        var customerContactsActions = function(url) {
            $("#customer-contacts-errors").addClass("hidden").html("");

            // Form-Data di invio.
            var formData = new window.FormData($("form#customer-contacts-form").get(0));

            $.ajax({
                type: "post",
                url: url,
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    var fields = ["firstname", "lastname", "email", "additional_name",
                                  "job_title", "phone", "mobile_phone"];
                    var blk = $("#customer-contacts-block");
                    blk.find("#contacts-customer-name").text(data["customer-name"]);

                    var loadLazyData = function() {
                        for (var name of fields) {
                            var field = blk.find("[data-te-input-wrapper-init] input.peer#contact-" + name.replace(/_/g, "-"));
                            var val = data.selected[name] ?? "";
                            field.val(val);
                            te.Input.getInstance(field.parent("[data-te-input-wrapper-init]").get(0)).update();
                        }

                        // Il metodo val() non triggera l'evento "input" (inputs.js), invoca esplicitamente l'handler
                        // per l'evento 'eventName' (all'occorrenza, al termine dello slideDown() della pagina corrente).
                        blk.find("[data-te-input-wrapper-init] input.peer").trigger(eventName);

                        var ta = $("#contact-notes");
                        var val = data.selected["notes"] ?? "";
                        var prevVal = ta.val();
                        ta.val(val);
                        te.Input.getInstance(ta.parent("[data-te-input-wrapper-init]").get(0)).update();

                        // Se il testo del textarea delle "Notes" è empty, serve temporaneamente il focus
                        // per aggiornare la posizione della label (workaround).
                        // Nota: l'assegnazione temporanea del focus è necessaria solo per la transizione
                        //       del contenuto da not-empty a empty.
                        if (val.length <= 0 && prevVal.length > 0) {
                            ta.get(0).focus({ preventScroll: true });
                            ta.trigger("blur");
                        }

                        // Popola la lista dei contatti.
                        var contacts = $("#customer-contact-names");
                        contacts.html(data.contacts).triggerHandler("select:update");
                        updateSelectFilter("#customer-contact-names");
                        updateSelectOptionHeight("#customer-contact-names");

                        validateContacts();
                    }

                    // Se la pagina "Customer Contacts" è completamente aperta, esegui il caricamento dei contatti,
                    // altrimenti, attendi che la pagina sia completamente aperta (evento "page-loaded:customer-contacts").
                    if (blk.css("overflow") != "hidden") loadLazyData();
                    // Il fadeOut viene eseguito in animateScroll() o nell'handler $(".exp-block .admin-selector").on("click").
                    else $(document).one("page-loaded:customer-contacts", loadLazyData);
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#customer-contacts-errors"); }
            });
        };

        // Gestione button "Modifica" del form "customer-contacts-form".
        $("#edit-customer-contact").on("click", function(evt) {
            customerContactsActions("/admin.customer-contacts.edit");
        });

        // Gestione del button "Elimina" del form "customer-contacts-form".
        $("#delete-customer-contact").on("click", function(evt) {
            // Richiama la funzione di utility per la gestione del dialogBox modale di conferma.
            openDeleteItemWarning($(this),
                                  function() {
                                      customerContactsActions("/admin.customer-contacts.delete");
                                  });
        });

        // Gestione button "Nuovo" del form "customer-contacts-form".
        $("#add-customer-contact").on("click", function(evt) {
            customerContactsActions("/admin.customer-contacts.add");
        });

        pageLoadCallbacks["load-customer-contacts-page"] = function() {
            customerContactsActions("/admin.customer-contacts.index");
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Job hierarchy block.

        const MAX_HIER_BLOCKS = 4;

        // Gestione del button "Add" di un level di "Job hierarchy block".
        // Nota: i 4 blocchi massimi possibili sono già presenti nel DOM e devono essere
        //       semplicemente visualizzati.
        $("#hier-level-add").on("click", function(evt) {
            var container = $(".job-hier-container");
            if (container.length <= 0 || $(this).hasClass("bt-disabled")) return;

            var blks = container.find(".hier-blk");
            var id = blks.filter(":visible").length;

            if (id < MAX_HIER_BLOCKS) {
                var blk = blks.eq(id);
                blk.find("input").val("").prop("disabled", false);  // Svuota gli input e abilitali.

                blk.slideDown("slow", function() {  // Visualizza il blocco.
                    validateJobHierarchy();
                });

                // Visualizza l'ultimo livello di sample.
                var sample = $("#hier-sample .hier-l").eq(id);
                sample.find("label[for^='hier-sample-l']").text("");
                sample.find("input[id^='hier-sample-l']").val("").attr({ "placeholder": "", "aria-label": "" });

                sample.fadeIn("slow");

                id++;
            }

            // Aggiorna i "notches" di tutti gli input del preview (le tre parti dell'input
            // a sinistra della label, la label stessa e a destra della label).
            $("#hier-sample [data-te-input-wrapper-init]").each(function() {
                te.Input.getInstance(this).update();
            });

            if (id >= MAX_HIER_BLOCKS) $(this).addClass("bt-disabled");
            if (id >= 2) blks.eq(0).find(".hier-trash").fadeIn("slow");
        });

        // Gestione dei button per l'eliminazione dei livelli di gerarchia.
        $(".hier-trash").on("click", function(evt) {
            var blk = $(this).closest(".hier-blk");  // Blocco da eliminare.
            var blks = $(".job-hier-container").find(".hier-blk");
            var idEnd = blks.filter(":visible").length - 1;

            var idStart = blks.index(blk);
            if (idStart < 0 || idEnd <= 0) return;

            // Sposta di una posizione indietro i valori degli input seguenti al blocco da eliminare.
            for ( var n = idStart; n < idEnd ; n++ ) {
                var inpDst = blks.eq(n).find("input");
                var inpSrc = blks.eq(n + 1).find("input");

                // Imposta il nuovo testo di ogni <input>.
                for ( var i = 0; i < inpDst.length; i++ ) inpDst.eq(i).val(inpSrc.eq(i).val());
            }

            blk = blks.eq(idEnd);
            blk.find("input").val("").prop("disabled", true);

            // Aggiorna i "notches" di tutti gli input del preview e dei livelli (le tre parti
            // dell'input: a sinistra della label, la label stessa e a destra della label).
            $("#hier-sample [data-te-input-wrapper-init]").each(function() {
                te.Input.getInstance(this).update();
            });
            blks.find("[data-te-input-wrapper-init]").each(function() {
                te.Input.getInstance(this).update();
            });

            blk.slideUp("slow", function() {  // Nascondi il blocco.
                var ln = blks.filter(":visible").length;
                if (ln < MAX_HIER_BLOCKS) $("#hier-level-add").removeClass("bt-disabled");
                if (idEnd <= 1) blks.eq(0).find(".hier-trash").fadeOut("fast");

                updateJobHierarchySamples();
                validateJobHierarchy();

                blks.find("input.peer").trigger(eventName);  // Trigger di tutti gli elementi <input.peer>.
            });

            // Nascondi l'ultimo livello di sample.
            $("#hier-sample .hier-l").eq(idEnd).fadeOut("slow");
        });

        $(".hier-blk.collapse").css("display", "none").removeClass("collapse h-0").addClass("mt-4 px-4 pt-3 pb-4");

        // Preimposta la visibilità dell'icona di trash del primo blocco.
        var n = $(".job-hier-container").find(".hier-blk").filter(":visible").length;
        if (n <= 1) $(".job-hier-container").find(".hier-blk").eq(0).find(".hier-trash").fadeOut("fast");

        var validateJobHierarchy = function() {
            var bName = $("select#job-hierarchy-names").val() !== null;
            var hierInp = $("input#new-job-hierarchy-name");
            var hierName = hierInp.val().trim().toLowerCase();
            var bNewName = hierName.length > 0, bNewDiff = true;

            $("select#job-hierarchy-names option").each(function() {
                // Determina se il new-name esiste già tra quelli nel <select#job-hierarchy-names>.
                if (hierName == $(this).text().toLowerCase()) return (bNewDiff = false);
            });
            var hierDOM = hierInp.get(0);
            hierInp.prop("title", hierInp.data((bNewDiff) ? "title" : "title-error"));
            if (hierDOM.setCustomValidity) hierDOM.setCustomValidity((bNewDiff) ? "" : "Error.");

            // Per ogni livello di gerarchia deve esserci almeno un nome valido (in una qualsiasi lingua).
            var bLevels = true;
            $(".job-hier-container").find(".hier-blk").filter(":visible").each(function(index) {
                var bLvl = false;
                var blk = $(this);

                // Itera gli <input> delle lingue del livello corrente.
                blk.find(".hier-langs input[name^='hier-']").each(function() {
                    if ($(this).val().trim().length > 0) {
                        bLvl = true;
                        return false;  // Termina l'iterazione di each().
                    }
                });

                if (!bLvl) {
                    bLevels = false;
                    blk.prop("title", blk.data("title"));
                    blk.addClass(bgError).find(".hier-level span").addClass(textError);
                }
                else {
                    blk.prop("title", "");
                    blk.removeClass(bgError).find(".hier-level span").removeClass(textError);
                }
            });

            var btnEdit = $("#edit-job-hierarchy");
            var btnDelete = $("#delete-job-hierarchy");
            var btnNew = $("#add-job-hierarchy");

            // Il button "#delete-job-hierarchy" è abilitato solo se la selezione del <select#job-hierarchy-names>
            // è valida.
            if (bName && btnDelete.is(":disabled")) btnDelete.prop("disabled", false);
            else if (!bName && btnDelete.is(":enabled")) btnDelete.prop("disabled", true);

            // Il button "#edit-job-hierarchy" è abilitato solo se la selezione di <select#job-hierarchy-names>
            // è valida e, per ogni livello di gerarchia, c'è almeno un nome valido (in una qualsiasi lingua).
            // Se la stringa di <input#new-job-hierarchy-name> è empty, allora rimarrà invariato nel DB.
            if (bName && bLevels && btnEdit.is(":disabled")) btnEdit.prop("disabled", false);
            else if ((!bName || !bLevels) && btnEdit.is(":enabled")) btnEdit.prop("disabled", true);

            // Il button "#add-job-hierarchy" è abilitato solo se, per ogni livello di gerarchia,
            // c'è almeno un nome valido (in una qualsiasi lingua) e se la stringa di
            // <input#new-job-hierarchy-name> NON è empty.
            if (bNewName && bNewDiff && bLevels && btnNew.is(":disabled")) btnNew.prop("disabled", false);
            else if ((!bNewName || !bNewDiff || !bLevels) && btnNew.is(":enabled")) btnNew.prop("disabled", true);
        };

        $("select#job-hierarchy-names").on("change", function(evt) {
            pageLoadCallbacks["load-job-hierarchy-page"]();
        });

        $("input#new-job-hierarchy-name").on(eventAll, function(evt) {
            validateJobHierarchy();
        });

        // Aggiorna le label dei sample dei livelli.
        var updateJobHierarchySamples = function() {
            // Itera i blocchi dei livelli visibili.
            $(".job-hier-container").find(".hier-blk").filter(":visible").each(function(index) {
                var strLabel = "";

                // Itera gli <input> delle lingue del livello corrente.
                $(this).find(".hier-langs input[name^='hier-']").each(function() {
                    // Estrai il codice della lingua dell'<input> corrente.
                    var lng = (/^hier-\d+-([a-z]{2})$/.exec($(this).prop("id")))[1];
                    var str = $(this).val().trim();

                    if (str.length > 0) {
                        // Imposta il testo della prima lingua non empty come label
                        // del sample del livello corrente.
                        // Non sovrascrivere la prima stringa trovata, non è sicuro che ci sia una
                        // label valida anche per la lingua corrente.
                        if (strLabel.length <= 0) strLabel = str;

                        // Se la lingua dell'<input> corrente è quella di default, termina il ciclo
                        // e assumi la stringa della variabile 'str' come label.
                        if (lng == currentLanguage) {
                            strLabel = str;
                            return false;  // Termina l'iterazione di each().
                        }
                    }
                });

                // Blocco del livello corrente.
                var blk = $("#hier-sample .hier-l").eq(index);
                var inp = blk.find("input[id^='hier-sample-l']");
                blk.find("label[for^='hier-sample-l']").text(strLabel);
                inp.attr({ "placeholder": strLabel, "aria-label": strLabel });

                // Aggiorna i "notches" dell'input corrente (le tre parti dell'input: a sinistra
                // della label, la label stessa e a destra della label).
                te.Input.getInstance(blk.get(0)).update();
            });
        };

        $(".hier-langs input[name^='hier-']").on(eventAll, function(evt) {
            updateJobHierarchySamples();
            validateJobHierarchy();
        }).triggerHandler(eventName);  // Trigger solo del primo elemento della collection.

        var hierarchyActions = function(url) {
            $("#job-hierarchy-errors").addClass("hidden").html("");

            // Form-Data di invio.
            var formData = new window.FormData($("form#job-hierarchy-form").get(0));

            $.ajax({
                type: "post",
                url: url,
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    $("#job-hierarchy-customer-name").text(data["customer-name"]);

                    updateSelectOptions("#job-hierarchy-names", data.hierarchies,
                                        { id: "id", label: "name", single: data.hierarchySel });
                    updateHierarchyBlocks(data.levels, "#hier-sample .hier-l", ".job-hier-container .hier-blk",
                                          ".hier-langs", "#hier-", "#hier-level-add", ".hier-trash", MAX_HIER_BLOCKS);
                    updateJobHierarchySamples();
                    validateJobHierarchy();

                    var doTriggers = function() {
                        // Il metodo val() non triggera l'evento "input" (inputs.js), invoca esplicitamente l'handler
                        // per l'evento 'eventName' (all'occorrenza, al termine dello slideDown() della pagina corrente).
                        $("#job-hierarchy-block [data-te-input-wrapper-init] input.peer").trigger(eventName);
                    };

                    if ($("#job-hierarchy-block").css("overflow") != "hidden") $(document).one("hier-block-slide", doTriggers);
                    else $(document).one("page-loaded:job-hierarchy", doTriggers);
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#job-hierarchy-errors"); }
            });
        };

        // Gestione button "Modifica" del form "job-hierarchy-form".
        $("#edit-job-hierarchy").on("click", function(evt) {
            $("#hier-level-count").val($(".job-hier-container .hier-blk:visible").length);
            hierarchyActions("/admin.job-hierarchy.edit");
        });

        // Gestione button "Elimina" del form "job-hierarchy-form".
        $("#delete-job-hierarchy").on("click", function(evt) {
            // Richiama la funzione di utility per la gestione del dialogBox modale di conferma.
            openDeleteItemWarning($(this),
                                  function() {
                                      hierarchyActions("/admin.job-hierarchy.delete");
                                  });
        });

        // Gestione button "Nuovo" del form "job-hierarchy-form".
        $("#add-job-hierarchy").on("click", function(evt) {
            $("#hier-level-count").val($(".job-hier-container .hier-blk:visible").length);
            hierarchyActions("/admin.job-hierarchy.add");
        });

        pageLoadCallbacks["load-job-hierarchy-page"] = function() {
            hierarchyActions("/admin.job-hierarchy.index");
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Employees block.

        var employeeToolsOneTime = function() {
            // Il metodo .one() esegue l'unbind dell'evento "show.te.dropdown" dopo la
            // prima volta che viene aperto il dropdown "#dropdown-employee-tools".
            // Inizializza tutti i <select.emp-tool-selector> ed esegui il bind
            // dell'evento "open.te.select" per tutti i <select.select.emp-tool-selector>.

            // Itera tutti i <select.emp-tool-selector>
            $("#employee-tools-block select.emp-tool-selector").each(function() {
                var sel = $(this);
                var wrapper = sel.closest("[data-te-select-wrapper-ref]");
                var outline = wrapper.find("[data-te-select-form-outline-ref]");

                wrapper.addClass("w-11");
                var inp = outline.find("input[data-te-select-input-ref]");
                inp.removeClass("pl-3 pr-8").addClass("pl-1.5 pr-5");
                outline.find("span.absolute").removeClass("w-5 h-5 right-3").addClass("w-4 h-4 right-1");

                // Imposta la classe effettiva della label relativa all'impostazione dei ogni <select.emp-tool-selector>.
                var vl = sel.find("option:selected").val();
                sel.closest(".select-sm-cont").next("div").removeClass("tool-write tool-read tool-none")
                                                          .addClass("tool-" + vl);

                // Quando il dropdown del <select> sta per essere aperto, inizializzalo.
                // Nota: il dropdown del <select> viene creato all'apertura e distrutto alla chiusura,
                //       quindi l'inizializzazione va fatta ad ogni apertura.
                sel.on("open.te.select", function(evt) {
                    var _sel = $(this);  // Closure di 'sel' utilizzata all'interno di setTimeout().

                    // Ritarda l'inizializzazione per dare il tempo al dropdown di essere creato.
                    // Nota: purtroppo non esiste l'evento triggerato DOPO che il dropdown è stato creato.
                    window.setTimeout(function() {
                        var container = $("div[data-te-select-dropdown-container-ref]");
                        var dropdown = container.find("div[data-te-select-dropdown-ref]");
                        var cls = /\b(min-w-\S+)/.exec(dropdown.prop("className"));
                        if (cls !== null) dropdown.removeClass(cls[1]);

                        dropdown.find("div[data-te-select-options-wrapper-ref]").on("click", function(evt) {
                            // Evita che il dropdown dei tools ("#dropdown-employee-tools") si chiuda
                            // quando viene chiuso il dropdown di un <select.emp-tool-selector>.
                            evt.stopPropagation();
                        });

                        // Copia i tooltip delle <option> dei <select.emp-tool-selector> nel rispettivi
                        // dropdown creati dinamicamente da tw-elements.
                        var items = dropdown.find("div[data-te-select-option-ref]");
                        var opts = _sel.find("option");
                        items.each(function(index) {
                            $(this).prop("title", opts.eq(index).prop("title"));
                        }).addClass("text-xs").find("span[data-te-select-option-text-ref]").addClass("mx-auto");

                        cls = /\b(px-\S+)/.exec(items.prop("className"));
                        if (cls !== null) items.removeClass(cls[1]);
                    }, 20);
                }).on("change", function(evt) {
                    // Il tooltip della <option> selezionata è già copiata nell'<input> del <select> dallo script "inputs.js".
                    var vl = $(this).find("option:selected").val();
                    $(this).closest(".select-sm-cont").next("div.tool-access-div")
                                                      .removeClass("tool-write tool-read tool-none")
                                                      .addClass("tool-" + vl);
                });
            });
        };

        var validateEmployees = function() {
            var bName = $("select#employee-names").val() !== null;

            var inpFirst = $("input#employee-firstname");
            var inpLast = $("input#employee-lastname");
            var inpEmail = $("input#employee-email");
            var bFirst = inpFirst.val().trim().length > 0;
            var bLast = inpLast.val().trim().length > 0;
            var bEmail = inpEmail.is(":valid");
            var bValid = bFirst && bLast && bEmail;

            inpFirst.prop("title", (bFirst) ? "" : inpFirst.data("title"));
            inpLast.prop("title", (bLast) ? "" : inpLast.data("title"));
            inpEmail.prop("title", (bEmail) ? "" : inpEmail.data("title"));

            var btnEdit = $("#edit-employee");
            var btnDelete = $("#delete-employee");
            var btnNew = $("#add-employee");

            // Il button "#delete-employee" è abilitato solo se la selezione del <select#employee-names>
            // non è l'ultima (più di un impiegato) e il "role" non è "siteAdmin".
            // Non si può eliminare un "siteAdmin" e neppure l'ultimo employee della lista.
            // Questa regola è implementata anche lato-server nel metodo delete() del controller
            // AdminEmployeesController.
            var emps = $("select#employee-names option").length > 1;
            var role = $("select#employee-role").val() != "siteAdmin";
            if (emps && role && btnDelete.is(":disabled")) btnDelete.prop("disabled", false);
            else if ((!emps || !role) && btnDelete.is(":enabled")) btnDelete.prop("disabled", true);

            // Il button "#edit-employee" è abilitato solo se la selezione di <select#employee-names>
            // e i tre field 'required' sono validi.
            if (bName && bValid && btnEdit.is(":disabled")) btnEdit.prop("disabled", false);
            else if ((!bName || !bValid) && btnEdit.is(":enabled")) btnEdit.prop("disabled", true);

            // Il button "#add-employee" è abilitato solo se i tre campi required sono validi.
            if (bValid && btnNew.is(":disabled")) btnNew.prop("disabled", false);
            else if (!bValid && btnNew.is(":enabled")) btnNew.prop("disabled", true);
        };

        $("select#employee-names").on("change", function(evt) {
            pageLoadCallbacks["load-employees-page"]();
        });

        $("input#employee-firstname, input#employee-lastname, input#employee-email").on(eventAll, function(evt) {
            validateEmployees();
        }).triggerHandler(eventName);  // Trigger solo del primo elemento della collection.

        var employeesActions = function(url) {
            $("#employees-errors").addClass("hidden").html("");

            // Form-Data di invio.
            var formData = new window.FormData($("form#employees-form").get(0));

            $.ajax({
                type: "post",
                url: url,
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    var fields = ["firstname", "lastname", "acronym", "employee_id",
                                  "phone", "mobile_phone", "email", "job_title"];
                    var blk = $("#employees-block");
                    blk.find("#employees-customer-name").text(data["customer-name"]);

                    var loadLazyData = function() {
                        for (var name of fields) {
                            var field = blk.find("[data-te-input-wrapper-init] input.peer#employee-" + name.replace(/_/g, "-"));
                            var val = data.selected[name] ?? "";
                            field.val(val);
                            te.Input.getInstance(field.parent("[data-te-input-wrapper-init]").get(0)).update();
                        }

                        // Resetta i campi "password".empty
                        $("#employee-password, #employee-password-new").val("");
                        te.Input.getInstance($("#employee-password").parent("[data-te-input-wrapper-init]").get(0)).update();
                        te.Input.getInstance($("#employee-password-new").parent("[data-te-input-wrapper-init]").get(0)).update();

                        // Il metodo val() non triggera l'evento "input" (inputs.js), invoca esplicitamente l'handler
                        // per l'evento 'eventName' (all'occorrenza, al termine dello slideDown() della pagina corrente).
                        blk.find("[data-te-input-wrapper-init] input.peer").trigger(eventName);

                        // Popola la lista degli impiegati.
                        var employees = $("#employee-names");
                        employees.html(data.employees).triggerHandler("select:update");
                        updateSelectFilter("#employee-names");
                        updateSelectOptionHeight("#employee-names");

                        // Imposta i <select> "language_code", "employee-role", "employee-status".
                        te.Select.getInstance($("#employee-language-code").get(0)).setValue(data.selected.language_code);
                        te.Select.getInstance($("#employee-role").get(0)).setValue(data.selected.role);
                        te.Select.getInstance($("#employee-status").get(0)).setValue(data.selected.employee_status);

                        // Imposta la foto dell'impiegato.

                        // Ottieni le due funzioni di inizializzazione dinamica (se non lo sono già).
                        getInitFuncs();

                        // Popola il dropdown degli accessi dell'impiegato corrente, inizializza e imposta
                        // l'evento "show.te.dropdown".
                        $("#employee-tools-block ul").html(data.accesses);
                        $("#employee-tools-block ul select.emp-tool-selector").each(function() {
                            new te.Select(this);    // Inizializza il <select>.
                            fnInitSelect($(this));  // Attach degli eventi custom e personalizzazione del <select>.
                        });
                        $("#dropdown-employee-tools").one("show.te.dropdown", employeeToolsOneTime);

                        // Visualizza la foto.
                        var photo = data.selected["photo_file"];  // null se nessuna foto è presente.
                        var spn = $("#employee-photo-label").find("span");
                        var img = $("#employee-photo-image");
                        var del = $("#employee-photo-delete");
                        (photo) ? spn.addClass("hidden") : spn.removeClass("hidden");
                        (photo) ? img.prop("src", photo).removeClass("hidden").closest(".employee-image-box").removeClass("h-[250px] border-2") :
                                  img.addClass("hidden").prop("src", "").closest(".employee-image-box").addClass("h-[250px] border-2");
                        (photo) ? del.removeClass("invisible") : del.addClass("invisible");

                        validateEmployees();

                        updateImpersonatingSelect();  // Aggiorna il <select#impersonated-employee>.
                    };

                    // Se la pagina "Employees" è completamente aperta, esegui il caricamento degli impiegati,
                    // altrimenti, attendi che la pagina sia completamente aperta (evento "page-loaded:employees").
                    if (blk.css("overflow") != "hidden") loadLazyData();
                    // Il fadeOut viene eseguito in animateScroll() o nell'handler $(".exp-block .admin-selector").on("click").
                    else $(document).one("page-loaded:employees", loadLazyData);
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#employees-errors"); }
            });
        };

        // Gestione button "Modifica" del form "employees-form".
        $("#edit-employee").on("click", function(evt) {
            employeesActions("/admin.employees.edit");
        });

        // Gestione button "Elimina" del form "employees-form".
        $("#delete-employee").on("click", function(evt) {
            // Richiama la funzione di utility per la gestione del dialogBox modale di conferma.
            openDeleteItemWarning($(this),
                                  function() {
                                      employeesActions("/admin.employees.delete");
                                  });
        });

        // Gestione button "Nuovo" del form "employees-form".
        $("#add-employee").on("click", function(evt) {
            employeesActions("/admin.employees.add");
        });

        // Gestione button "Resetta" del form "employees-form".
        $("#reset-failed-passwords").on("click", function(evt) {
            $("#employee-failed-passwords").val("0");
        });

        pageLoadCallbacks["load-employees-page"] = function() {
            employeesActions("/admin.employees.index");
        };

        // Gestione button "Delete photo" del form "employees-form".
        $("#employee-photo-delete").on("click", function(evt) {
            $("#employees-errors").addClass("hidden").html("");

            $.ajax({
                type: "post",
                url: "/admin.employees.delete-photo",
                dataType: "json",
                data: {
                    "employee-names": $("#employee-names").val(),
                    _token: $("#employees-form input[type=hidden][name=_token]").val()  // Il token csrf è necessario.
                },
                success: function(data, textStatus, jqXHR) {
                    if (data.deleted) {
                        // L'impiegato è stato eliminato (data.deleted == true).
                        $("#employee-photo-label").find("span").removeClass("hidden");
                        $("#employee-photo-image").addClass("hidden").prop("src", "")
                                                .closest(".employee-image-box").addClass("h-[250px] border-2");
                        $("#employee-photo-delete").addClass("invisible");

                        loadEmployeePhoto();  // Aggiorna la foto nella window del menu a sinistra.
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#employees-errors"); }
            });
        });

        //////////////////////////////////////////////////////////////////////////////////
        // Drag & Drop della foto del employees-block.

        // Array di oggetti Files ottenuti tramite Drag & Drop.
        var employeeDroppedFiles = [];

        $("input#employee-photo[type=file]").each(function(index) {
            if (typeof(this.draggable) != "undefined") this.draggable = true;
        });

        $("input#employee-photo[type=file]").on("drop dragover dragenter", function(evt) {
            evt.preventDefault();
        });

        // Eventi Drag & Drop per il <div.employee-image-box>
        $("div.employee-image-box").on("dragenter dragleave dragover", function(evt) {
            // Il div è assunto come drop target (preventDefault()) se il drag contiene dei
            // files (types.contains("Files")).
            // Nota: non utilizzare il metodo includes() (dell'array types), non è standard e non
            //       è supportato da versioni vecchie di browser (IE, Opera 12.18, Safari 5.1.7).
            //       Utilizzare il metodo indexOf().
            evt.originalEvent.dataTransfer.dropEffect = "none";
            var types = evt.originalEvent.dataTransfer.types;

            if (types && types.indexOf("Files") >= 0 && checkDropFileType(evt.originalEvent.dataTransfer.items)) {
                evt.preventDefault();   // Non strettamente necessario.
                evt.stopPropagation();  // Necessario !!!
                evt.originalEvent.dataTransfer.dropEffect = "copy";

                var div = $(this);
                if (evt.type == "dragenter") div.addClass("drag-over");
                else if (evt.type == "dragleave") {
                    // Determina se il mouse si trova ancora nell'area del div.
                    // Nota: l'evento dragleave viene infatti generato anche quando il mouse
                    //       entra all'interno dell'immagine SVG e dello span che sono child
                    //       del div.
                    var offset = div.offset();
                    var w = div.outerWidth();
                    var h = div.outerHeight();
                    var b = evt.pageX >= offset.left && evt.pageX < (offset.left + w) &&
                            evt.pageY >= offset.top && evt.pageY < (offset.top + h);
                    if (!b) div.removeClass("drag-over");
                }
            }
        }).on("drop", function(evt) {  // Evento ondrop del div.
            evt.preventDefault();
            $(this).removeClass("drag-over");

            var files = evt.originalEvent.dataTransfer.files;
            if (files && files.length > 0) {
                // Reset dell'input#employee-photo[type=file].
                resetInputFile($("input#employee-photo[type=file]"));

                // Aggiungi i dropped file all'array employeeDroppedFiles, se del tipo supportato.
                employeeDroppedFiles = [];
                for ( var n = 0; n < files.length ; n++ ) {
                    if (acceptedImageMIMEs.indexOf(files[n].type) < 0) continue;

                    employeeDroppedFiles.push(files[n]);
                }

                uploadEmployeePhoto();
            }
        }).on("dragend dragexit", function(evt) {
            $(this).removeClass("drag-over");
        });

        // Gestione del button di selezione dell'attachment dell'immagine dell'utente.
        $("input#employee-photo[type=file]").on("change", function(evt) {
            var input = $(this);

            // Aggiungi i dropped file all'array employeeDroppedFiles, se del tipo supportato.
            employeeDroppedFiles = [];

            var files = input.prop("files");
            if (files !== undefined) {
                for ( var n = 0; n < files.length ; n++ ) {
                    if (acceptedImageMIMEs.indexOf(files[n].type) < 0) continue;

                    employeeDroppedFiles.push(files[n]);
                }
            }

            uploadEmployeePhoto();
        });

        // Carica immediatamente la foto dell'utente, invocato sia tramite drag&drop che tramite browse-file.
        var uploadEmployeePhoto = function() {
            if (employeeDroppedFiles.length <= 0) return;

            $("#employees-errors").addClass("hidden").html("");

            // Aggiungi al FormData il primo file immagine dell'array employeeDroppedFiles.
            var formData = new window.FormData();
            formData.append("employeePhoto", employeeDroppedFiles[0]);
            formData.append("employee-names", $("#employee-names").val());
            formData.append("_token", $("#employees-form input[type=hidden][name=_token]").val());  // Il token csrf è necessario.

            $.ajax({
                type: "post",
                url: "/admin.employees.upload-photo",
                dataType: "json",
                data: formData,
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    if (data.photo !== null) {
                        $("#employee-photo-label").find("span").addClass("hidden");
                        $("#employee-photo-image").prop("src", data.photo).removeClass("hidden")
                                                  .closest(".employee-image-box").removeClass("h-[250px] border-2");
                        $("#employee-photo-delete").removeClass("invisible");

                        loadEmployeePhoto();  // Aggiorna la foto nella window del menu a sinistra.
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#employees-errors"); }
            });
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Sections block.

        // Ottieni le stringhe (lingua corrente) per la costruzione dinamica dei livelli
        // e delle sezioni.
        var sectionStrings = $("#org-levels-container");
        var levelLabel = sectionStrings.data("level-label") ?? "";
        var levelSectionLabel = sectionStrings.data("level-section-label") ?? "";
        var levelDeleteTooltip = sectionStrings.data("level-delete-tooltip") ?? "";
        var addSectionTooltip = sectionStrings.data("add-section-tooltip") ?? "";
        var levelErrorTooltip = sectionStrings.data("level-error-tooltip") ?? "";
        var sectionErrorTooltip = sectionStrings.data("section-error-tooltip") ?? "";
        var sectionLabel = sectionStrings.data("section-label") ?? "";
        var sectionDeleteTooltip = sectionStrings.data("section-delete-tooltip") ?? "";
        var parentSectionLabel = sectionStrings.data("parent-section-label") ?? "";
        var sectionParentHoverClasses = sectionStrings.data("section-parent-hover-classes") ?? "";
        var sectionData = sectionStrings.data("section-languages");
        var sectionLanguages = (sectionData) ? sectionData.split("\f") : [];

        // Dopo l'iterazione, l'array sectionLanguages conterrà una serie di oggetti con
        // il seguente formato:
        //   sectionLanguages = [ { code: "it", label: "Italiano" },
        //                        { code: "en", label: "English" },
        //                        { code: "fr", label: "Français" },
        //                        { code: "de", label: "Deutsch" } ];
        for ( var n = 0; n < sectionLanguages.length; n++ ) {
            var lang = sectionLanguages[n].split(":");

            // Utilizza la parte di stringa seguente al "code" come "label" (nel caso la label contenga
            // dei caratteri ':'), il parametro 'limit' del metodo split() non agisce come il parametro
            // 'limit' della funzione explode() di PHP.
            sectionLanguages[n] = { code: lang[0], label: sectionLanguages[n].slice(lang[0].length + 1) };
        }

        // Rimuovi le classi "collapse" e "h-0", aggiungi la classe "py-2" ed aggiungi
        // lo style "display: none".
        sectionStrings.find(".org-level-langs, .org-section-langs").css("display", "none")
                                                                   .removeClass("collapse h-0")
                                                                   .addClass("py-2");


        // Struttura HTML:
        //   #org-levels-container                           // Contiene tutti i livelli con relative sezioni.
        //       .org-level-blk (data-org-level-id)          // Contenitore di un singolo blocco di un livello gerarchico.
        //           .org-level-data (data-title)            // Contiene il nome e le lingue del livello (data-org-level-id).
        //               .org-level-title                    // Expander, titolo e icona trash del livello.
        //                   .level-exp-arrow                // Icona expander.
        //                   .level-label                    // "Livello:".
        //                       .level-name                 // Nome del livello (dinamico).
        //                   .level-trash                    // Icona trash del livello.
        //               .org-level-langs                    // <input> per le lingue dei nomi del livello.
        //                   => per ogni lingua:
        //                        .org-level-<level>-<lang>
        //           .org-level-aside                        // Colonna a sinistra (span-rows delle sezioni del livello corrente).
        //           .org-sections-container                 // Contiene tutte le sezioni del livello corrente.
        //               .org-sections-info                  // Info e icona di "add" di una nuova sezione.
        //                   .org-sections-label             // Sezioni del Livello "X".
        //                   .org-level-section-add          // Icona di "add" di una nuova sezione.
        //               .org-sections-list                  // Contenitore delle sezioni (.org-section-item) del livello corrente.
        //                   .org-section-item (data-org-section-id, data-employees)  // Un <div> per ogni sezione.
        //                       .org-section-data (data-title)
        //                           .org-section-title      // Expander, titolo e icona trash della sezione oppure
        //                                                   // org-section-parent-title"
        //                               .section-exp-arrow  // Icona expander.
        //                               .section-label      // "Sezione:".
        //                                   .section-name   // Nome della sezione (dinamico).
        //                               div.section-parent-container
        //                                   select.section-parent  // se ".org-section-parent-title".
        //                               .section-trash      // Icona trash della sezione.
        //                           .org-section-langs      // <input> per le lingue dei nomi della sezione.
        //                               => per ogni lingua:
        //                                    .org-section-<level>-<section>-<lang>
        //                   [.org-section-item]             // Prossime sezioni.
        //       [.org-level-blk]                            // Prossimi livelli.

        // Gestione degli expander dei livelli e delle sezioni.
        var levelSectionExpander = function(evt) {
            var span = $(this);
            var blk = span.parent(".org-level-title, .org-section-title, .org-section-parent-title")
                          .next(".org-level-langs, .org-section-langs");

            if (span.hasClass("rotate-[-180deg]")) {
                span.removeClass("rotate-[-180deg]");
                blk.slideUp("slow");
            }
            else {
                span.addClass("rotate-[-180deg]");
                blk.slideDown("slow");

                blk.find("[data-te-input-wrapper-init]").each(function() {
                    te.Input.getInstance(this).update();
                });
            }
        };
        $(".org-level-title .level-exp-arrow, .org-section-title .section-exp-arrow, " +
          ".org-section-parent-title .section-exp-arrow").on("click", levelSectionExpander);

        // Gestione dell'expander dell'extra info.
        var extraInfo = $("#org-info-exp-arrow").on("click", function(evt) {
            var span = $(this);
            var svg = span.find("svg");
            var blk = $("#org-extra-info");

            if (svg.hasClass("rotate-[-180deg]")) {
                span.prop("title", span.data("title"));
                svg.removeClass("rotate-[-180deg]");
                blk.slideUp("slow");
            }
            else {
                span.prop("title", span.data("title-less"));
                svg.addClass("rotate-[-180deg]");
                blk.slideDown("slow");
            }
        });
        extraInfo.prop("title", extraInfo.data("title"));

        // Gestione degli eventi hover (enter e leave).
        var setSectionHover = function(evt, label) {
            // Se l'evento è "mouseleave", rimuovi la classe 'sectionParentHoverClasses' da tutti
            // gli elementi ".org-section-data".
            // Nota: l'evento "mouseleave" di un precedente "mouseenter" è sempre triggerato prima
            //       di un successivo "mouseenter".
            if (evt.type == "mouseleave") {
                sectionStrings.find(".org-section-data").removeClass(sectionParentHoverClasses);
                return;
            }

            // Background della sezione corrente (classe ".section-label").
            label.closest(".org-section-data").addClass(sectionParentHoverClasses);

            var blk = label.closest(".org-level-blk");

            // Ottieni il <select> per la sezione parente della sezione corrente.
            var parentSel = label.next(".section-parent-container").find("select.section-parent");
            if (parentSel.length > 0) {
                var parentId = parentSel.val();  // Id della sezione parente nel livello superiore.

                // Ottieni l'elemento ".org-section-data" della sezione parente (livello superiore)
                // e assegnagli la classe 'sectionParentHoverClasses'.
                blk.prev(".org-level-blk").find(".org-section-item[data-org-section-id=" + parentId + "]")
                                          .find(".org-section-data").addClass(sectionParentHoverClasses);
            }

            var nextBlk = blk.next(".org-level-blk");
            if (nextBlk.length > 0) {
                // Id della sezione corrente.
                var parentId = label.closest(".org-section-item").data("org-section-id");

                // Determina, tra la collection di sezioni del livello inferiore, quali hanno la sezione
                // con indice 'parentId' sezione parente.
                var datas = nextBlk.find(".org-sections-list .org-section-item").find(".org-section-data")
                                   .filter(function() {
                    var sel = $(this).find("select.section-parent");
                    return sel.val() == parentId;
                });

                // Background delle sezioni child (livello inferiore).
                datas.addClass(sectionParentHoverClasses);
            }
        };

        sectionStrings.find(".section-label").on("mouseenter", function(evt) {  // Mouse enter.
            setSectionHover(evt, $(this));
        }).on("mouseleave", function(evt) {  // Mouse leave.
            setSectionHover(evt, $(this));
        });

        var validateSections = function() {
            // Se esiste anche una sola area con il background 'bgError', disabilita il button "Save".
            var btnSave = $("#save-sections");
            var bValid = sectionStrings.find("." + bgError).length <= 0;
            if (bValid && btnSave.is(":disabled")) btnSave.prop("disabled", false);
            else if (!bValid && btnSave.is(":enabled")) btnSave.prop("disabled", true);
        };

        var setLevelSectionName = function(evt) {
            // Nota: questa callback è richiamata dall'evento .on(eventAll, setLevelSectionName),
            //       quindi, this corrisponde all'istanza DOM che ha triggerato l'evento 'eventAll'.

            // Trova il primo 'name' non blank (in qualsiasi lingua, per il level o per la sezione).
            var parent = $(this).closest(".org-level-langs, .org-section-langs");
            var span = parent.prev(".org-level-title, .org-section-title, .org-section-parent-title")
                             .find(".level-name, .section-name");
            var name = "";
            parent.find("input.peer").each(function() { // org-section-1-1-en"
                // Estrai il codice della lingua dell'<input> corrente.
                var lng = (/^(?:org-level|org-section-\d+)-\d+-([a-z]{2})$/.exec($(this).prop("id")))[1];
                var str = $(this).val().trim();

                if (str.length > 0) {
                    if (name.length <= 0) name = str;

                    if (lng == currentLanguage) {
                        name = str;
                        return false;  // Termina l'iterazione di each().
                    }
                }
            });

            span.text(name);

            var dataArea = parent.parent(".org-level-data, .org-section-data");
            if (name.length > 0 && dataArea.hasClass("org-level-data")) {
                // Se il controllo è effettuato su un "level" (non una "section"), per essere valido
                // il livello deve anche contenere almeno una sezione.
                if (dataArea.nextAll(".org-sections-container")
                            .find(".org-section-item").length <= 0) name = "";
            }

            (name.length > 0) ? dataArea.removeClass(bgError).prop("title", "")
                                        .next(".org-level-aside").removeClass(bgError) :
                                dataArea.addClass(bgError).prop("title", dataArea.data("title"))
                                        .next(".org-level-aside").addClass(bgError);

            validateSections();

            // Aggiorna le <option> dei <select> del livello inferiore (se è stato modificato
            // il nome di una sezione del livello corrente).
            if (parent.hasClass("org-section-langs")) {
                // Id della sezione contenente l'input che ha appena triggerato l'evento 'eventAll'.
                var id = parent.closest(".org-section-item").data("org-section-id");

                // Itera tutti i <select> per le sezioni parente del livello inferiore.
                parent.closest(".org-level-blk").next(".org-level-blk").find("select.section-parent").each(function() {
                    // Aggiorna la label della <option> con value 'id' per tutti i <select>.
                    $(this).find("option").filter(function() {
                        // Limita la collection di <option> del <select> corrente all'unica che ha un
                        //   value == id.
                        return $(this).prop("value") == id;
                    }).text(name);
                });
            }
        };


        // Aggiungi un nuovo livello di gerarchia.
        $("#org-level-add").on("click", function(evt) {
            // Ottieni le due funzioni di inizializzazione dinamica (se non lo sono già).
            getInitFuncs();

            // L'id di livello è incrementale a partire dal valore 1 (senza gap).
            var levelIndex = sectionStrings.find(".org-level-blk").length + 1;

            var html = "<div class=\"org-level-blk collapse h-0\" data-org-level-id=\"" + levelIndex + "\">" +
                         "<div class=\"org-level-data " + bgError + "\" data-title=\"" + levelErrorTooltip + "\">" +
                           "<div class=\"org-level-title\">" +
                             "<span class=\"level-exp-arrow\"><svg class=\"h-4 w-4 stroke-neutral-800 hover:a4-stroke-shade-300\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M19.5 8.25l-7.5 7.5-7.5-7.5\"></path></svg></span>" +
                             "<span class=\"level-label\">" + levelLabel + ": <span class=\"level-name\"></span></span>" +
                             "<span class=\"level-trash\" title=\"" + levelDeleteTooltip + "\"><svg class=\"w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300\" viewBox=\"0 0 16 16\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\"></path><path fill-rule=\"evenodd\" d=\"M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z\"></path></svg></span>" +
                           "</div>" +
                           "<div class=\"collapse h-0 org-level-langs\">";

            var levelLangs = "";
            for ( var n = 0; n < sectionLanguages.length; n++ ) {
                var lbl = sectionLanguages[n].label;
                var lvlId = "org-level-" + levelIndex + "-" + sectionLanguages[n].code;
                levelLangs += "<div class=\"relative mt-1\" data-te-input-wrapper-init=\"\">" +
                                "<input id=\"" + lvlId + "\" name=\"" + lvlId + "\" type=\"text\" placeholder=\"" + lbl + "\" maxlength=\"64\" class=\"" + inputClasses + "\" />" +
                                "<label for=\"" + lvlId + "\" class=\"" + labelClasses + "\">" +
                                lbl + "</label></div>";
            }

            html += levelLangs;
            html += "</div></div>" +
                    "<div class=\"org-level-aside\" title=\"" + levelLabel + " " + levelIndex + "\">" + levelIndex + "</div>" +
                    "<div class=\"org-sections-container\">" +
                      "<div class=\"org-sections-info\">" +
                        "<span class=\"org-sections-label self-center\">" + levelSectionLabel + " " + levelIndex + "</span>" +
                        "<span class=\"org-level-section-add cursor-pointer self-center\" title=\"" + addSectionTooltip + "\"><svg class=\"w-6 h-6 fill-neutral-800 hover:a4-fill-shade-300 transition-all duration-300 ease-linear\" viewBox=\"0 0 16 16\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z\"></path><path d=\"M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z\"></path></svg></span>" +
                      "</div>" +
                      "<div class=\"org-sections-list\"></div>" +
                    "</div></div>";

            html = $(html);
            html.find(".level-exp-arrow").on("click", levelSectionExpander);
            html.find(".level-trash").on("click", orgDeleteLevel);
            html.find(".org-level-section-add").on("click", orgAddSection);

            // Inizializza tutti gli <input> (attach della libreria twe) delle lingue per il nome del livello.
            html.find(".org-level-langs [data-te-input-wrapper-init]").each(function() {
                new te.Input(this);  // Inizializza l'<input>.

                var inp = $(this).find("input.peer");
                inp.on(eventAll, setLevelSectionName).triggerHandler(eventName);
                fnInitInput(inp);  // Attach degli eventi custom e personalizzazione dell'<input>.
            });

            html.find(".org-level-langs").css("display", "none").removeClass("collapse h-0").addClass("py-2");
            html.css("display", "none").removeClass("collapse h-0");

            sectionStrings.append(html);
            html.slideDown("slow");
            validateSections();
        });


        var orgDeleteLevel = function(evt) {  // Elimina il livello di gerarchia corrente.
            // Se il livello non è l'ultimo, shift down dei livelli successivi:
            //   • renumbering di <input#id>, <input[name]> e <label[for]> (delle lingue dei livelli)".
            //   • renumbering di <input#id>, <input[name]> e <label[for]> (delle lingue delle sezioni).
            //   • renumbering dell'indice del livello nell'area "org-level-aside".
            //   • renumbering dell'indice del livello delle sezioni nell'area "org-sections-info".
            //   • se il livello eliminato è il primo, elimina tutti i <select> per la sezione parente dal livello
            //     inferiore (che ora diventa il primo).
            //   • se il livello eliminato non è il primo, tutti i <select> per la sezione parente dal livello
            //     inferiore devono essere aggiornati con le sezioni del livello superiore (che ora diventa il
            //     parente del livello inferiore).
            var blk = $(this).closest(".org-level-blk");
            var levelIndex = parseInt(blk.data("org-level-id"), 10);
            var nextBlk = blk.next(".org-level-blk");
            var prevBlk = blk.prev(".org-level-blk");

            // Nota: gli id di livello vanno rinumerati in modo che siano incrementali a partire dal valore 1
            //       e non devono avere dei gap (saranno utilizzati per impostare la colonna `level` della
            //       tabella `section_level`).
            //       Gli id di sezione restano invariati, sono valori univoci locali e nel database saranno
            //       sostituiti dal valore AUTO_INCREMENT generato dalla tabella `section`.


            // Chiudi il livello ed eliminalo alla fine dell'animazione "slideUp".
            blk.slideUp("slow", function() {
                blk.remove();  // Rimuovi il livello.

                // Itera tutti i livelli, da quello che ha preso il posto del livello eliminato, fino all'ultimo.
                // Nota: il primo blocco iterato della collection filtrata da slice() ha sempre l'index 0.
                sectionStrings.find(".org-level-blk").slice(levelIndex - 1).each(function(index) {
                    // Ottieni la collection di tutti gli <input> delle lingue del livello corrente.
                    blk = $(this);
                    var inps = blk.find(".org-level-langs input.peer");// org-level-1-en
                    var currLevel = levelIndex + index;

                    // L'attributo "data-org-level-id" esiste già, quindi attributo e data sono diventati
                    // indipendenti, imposta entrambi con 'currLevel'.
                    blk.attr("data-org-level-id", currLevel).data("org-level-id", currLevel);

                    // Renumbering degli <input> per le lingue del nome del livello.
                    inps.each(function() {
                        var inp = $(this);
                        var rs = /^org-level-\d+-([a-z]{2})$/i.exec(inp.prop("id"));  // Estrai il "langCode".
                        var lvlId = "org-level-" + currLevel + "-" + rs[1];
                        inp.prop({ id: lvlId, name: lvlId });
                        inp.next("label").prop("for", lvlId);
                    });

                    // Renumbering dell'indice del livello nell'area "org-level-aside".
                    blk.find(".org-level-aside").prop("title", levelLabel + " " + currLevel).text(currLevel);

                    // Renumbering dell'area "org-sections-info".
                    blk.find(".org-sections-info .org-sections-label").text(levelSectionLabel + " " + currLevel);

                    // Itera tutte le sezioni del livello corrente.
                    blk.find(".org-section-item").each(function(sectIndex) {
                        // Ottieni la collection di tutti gli <input> delle lingue delle sezione corrente.
                        var item = $(this);  // org-section-1-1-en
                        var inps = item.find(".org-section-langs input.peer");
                        var sectId = item.data("org-section-id");

                        // La sezione corrente è stata inserita (inserted), modifica l'index del livello
                        // a tutti gli <input> e alle <label> associate.
                        // Renumbering degli <input> per le lingue del nome della sezione.
                        inps.each(function() {
                            var inp = $(this);

                            // Estrai il "langCode" (l'id di sezione corrisponde a sectId, non serve estrarlo).
                            var rs = /^org-section-\d+-\d+-([a-z]{2})/i.exec(inp.prop("id"));
                            var lvlId = "org-section-" + currLevel + "-" + sectId + "-" + rs[1];
                            inp.prop({ id: lvlId, name: lvlId });
                            inp.next("label").prop("for", lvlId);
                        });

                        // Modifica l'index della sezione all'eventuale <select> per la sezione parente.
                        if (levelIndex > 1) {
                            var lvlId = "org-parent-" + currLevel + "-" + sectId;
                            item.find("select.section-parent").prop({ id: lvlId, name: lvlId });
                        }
                    });
                });

                // Nota: nextBlk (se esiste) è il blocco che prende il posto del blocco appena eliminato.
                //       prevBlk (se esiste) è il blocco di livello parente del blocco appena eliminato.

                if (levelIndex <= 1) {  // Il primo livello è stato eliminato.
                    // Modifica il nome della classe da "org-section-parent-title" a "org-section-title"
                    // e rimuovi l'elemento "div.section-parent-container" con il <select> contenuto.
                    nextBlk.find(".org-section-parent-title").removeClass("org-section-parent-title")
                                                             .addClass("org-section-title")
                                                             .find("div.section-parent-container")
                                                             .remove();
                }
                else {  // Un livello intermedio è stato eliminato, prevBlk è valido.
                    // Numero di sezioni del nuovo livello parente.
                    //var parentSects = prevBlk.find(".org-section-item").length;

                    var opts = "";

                    // Itera le sezioni del livello parente e aggiorna il nuovo blocco sostitutivo a
                    // quello eliminato.
                    prevBlk.find(".org-section-item").each(function() {
                        var sectId = $(this).data("org-section-id");
                        opts += "<option value=\"" + sectId + "\"></option>";
                    });

                    // Itera tutti i <select> delle sezioni del livello inferiore.
                    nextBlk.find(".org-section-item").each(function() {
                        var sel = $(this).find("select.section-parent");
                        sel.html(opts);

                        // Aggiungi la classe "text-sm" alle <option> del <select> corrente.
                        // Serve un piccolo delay per l'assestamento delle nuove <option>.
                        // Nota: ogni modifica alle <option> di un te.Select ripristina il css di default,
                        //       di conseguenza, la classe "text-sm" va ripristinata.
                        window.setTimeout(function() {
                            var teSel = te.Select.getInstance(sel.get(0));
                            addOptionClasses(teSel, sel, "text-sm");
                        }, 50);
                    });

                    // Rigenera il contenuto le entries delle <option> simulando la modifica
                    // del contenuto dei nomi delle sezioni.
                    prevBlk.find(".org-section-langs").each(function() {
                        $(this).find("input.peer").trigger(eventName);  // Trigger di tutti gli elementi <input.peer>.
                    });
                }

                validateSections();
            });
        };
        $(".level-trash").on("click", orgDeleteLevel);


        // Aggiungi una nuova sezione al livello di gerarchia corrente.
        var orgAddSection = function(evt) {
            // Ottieni le due funzioni di inizializzazione dinamica (se non lo sono già).
            getInitFuncs();

            var blk = $(this).closest(".org-level-blk");
            var levelIndex = parseInt(blk.data("org-level-id"), 10);

            // L'id del livello (".org-level-blk[data-org-level-id]") deve essere incrmentale a
            // partire dal valore 1 (senza gap, visto che sarà utilizzato per impostare il valore
            // della colonna section_level.`level`).
            // L'id della sezione, invece, deve solo essere univoco (può avere dei gap e valori
            // superiori a sezioni che risiedono in livelli inferiori).
            // Gli id di sezione servono solo per essere referenziati come parenti di altre sezioni,
            // quando la struttura delle sezioni viene salvata, gli id effettivi delle sezioni sono
            // assunti dall'AUTO_INCREMENT della tabella `section`.
            // Nota:quando la pagina delle sezioni viene aperta (Ajax richiede i dati al DB), il
            //      codice HTML verrà inizialmente generato con gli id delle sezioni incrementali
            //      a partire dal valore 1 e senza gap, l'aggiunta e la cancellazione di livelli
            //      e sezioni potrebbe inserire dei gap e interrompere l'incrementalità degli id.
            // Determina il valore maggiore degli id di sezione e aggiungi 1 (valore univoco).
            var sectionIndex = 0;
            sectionStrings.find(".org-section-item").each(function() {
                var sectId = parseInt($(this).data("org-section-id"), 10);
                if (sectId > sectionIndex) sectionIndex = sectId;
            });
            sectionIndex++;

            var sectTitle = (levelIndex > 1) ? "org-section-parent-title" : "org-section-title";
            var html = "<div class=\"org-section-item collapse h-0\" data-org-section-id=\"" + sectionIndex + "\">" +
                         "<div class=\"org-section-data " + bgError + "\" data-title=\"" + sectionErrorTooltip + "\">" +
                           "<div class=\"" + sectTitle + "\">" +
                             "<span class=\"section-exp-arrow\"><svg class=\"h-4 w-4 stroke-neutral-800 hover:a4-stroke-shade-300\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M19.5 8.25l-7.5 7.5-7.5-7.5\"></path></svg></span>" +
                             "<span class=\"section-label\">" + sectionLabel + ": <span class=\"section-name\"></span></span>";

            if (levelIndex > 1) {
                // Determina i nomi correnti delle sezioni del livello superiore.
                var options = "";
                blk.prev(".org-level-blk").find(".org-section-item").each(function() {
                    var name = $(this).find(".org-section-data .section-name").text();
                    var parentSect = $(this).data("org-section-id");
                    options += "<option value=\"" + parentSect + "\">" + name + "</option>";
                });

                var selId = "org-parent-" + levelIndex + "-" + sectionIndex;
                html += "<div class=\"section-parent-container\"><select id=\"" + selId + "\" name=\"" + selId + "\" class=\"section-parent\" data-te-select-init=\"\" data-te-select-size=\"sm\" data-te-select-option-height=\"26\" data-te-select-visible-options=\"6\">";
                html += options;
                html += "</select><label data-te-select-label-ref=\"\">" + parentSectionLabel + "</label></div>";
            }

            html += "<span class=\"section-trash\" title=\"" + sectionDeleteTooltip + "\"><svg class=\"w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300\" viewBox=\"0 0 16 16\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\"></path><path fill-rule=\"evenodd\" d=\"M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z\"></path></svg></span></div>" +
                    "<div class=\"collapse h-0 org-section-langs\">";

            var sectionLangs = "";
            for ( var n = 0; n < sectionLanguages.length; n++ ) {
                var lbl = sectionLanguages[n].label;
                var lvlId = "org-section-" + levelIndex + "-" + sectionIndex + "-" + sectionLanguages[n].code;
                sectionLangs += "<div class=\"relative mt-1\" data-te-input-wrapper-init=\"\">" +
                                  "<input type=\"text\" id=\"" + lvlId + "\" name=\"" + lvlId + "\" placeholder=\"" + lbl + "\" class=\"" + inputClasses + "\" maxlength=\"64\" />" +
                                  "<label for=\"" + lvlId + "\" class=\"" + labelClasses + "\">" +
                                  lbl + "</label></div>";
            }

            html += sectionLangs;
            html += "</div></div></div>";

            html = $(html);
            html.find(".section-exp-arrow").on("click", levelSectionExpander);
            html.find(".section-trash").on("click", orgDeleteSection);

            // Inizializza tutti gli <input> (attach della libreria twe) delle lingue per il nome della sezione.
            html.find(".org-section-langs [data-te-input-wrapper-init]").each(function() {
                new te.Input(this);  // Inizializza l'<input>.

                var inp = $(this).find("input.peer");
                inp.on(eventAll, setLevelSectionName).triggerHandler(eventName);
                fnInitInput(inp);  // Attach degli eventi custom e personalizzazione dell'<input>.
            });

            // Binding dell'evento hover.
            html.find(".section-label").on("mouseenter", function(evt) { setSectionHover(evt, $(this)); })
                                       .on("mouseleave", function(evt) { setSectionHover(evt, $(this)); });

            // Ottieni l'eventuale <select> per il parente della sezione appena creata.
            var parentSel = html.find("select[data-te-select-init]");

            html.find(".org-section-langs").css("display", "none").removeClass("collapse h-0").addClass("py-2");
            html.css("display", "none").removeClass("collapse h-0");

            blk.find(".org-sections-list").append(html);
            html.slideDown("slow");

            // Controlla i nomi del livello della sezione appena inserita (se questa è la prima sezione).
            if (sectionIndex <= 1) blk.find(".org-level-langs input.peer").trigger(eventName); // Trigger di tutti gli elementi <input.peer>.

            validateSections();

            // Aggiungi una nuova <option> ai <select> per le sezioni parente del livello inferiore
            // in modo che includano come parente anche la nuova sezione appena creata.
            var childSelects = blk.next(".org-level-blk").find("select.section-parent");
            childSelects.each(function() {
                $(this).append("<option value=\"" + sectionIndex + "\"></option>");
            });

            if (parentSel.length > 0) {
                // Inizializza il <select> del Tailwind element.
                // Nota: questo statement deve essere eseguito dopo che il blocco della sezione
                //       è stato aggiunto al document (.append()).
                var teSel = new te.Select(parentSel.get(0));    // Inizializza il <select>.
                addOptionClasses(teSel, parentSel, "text-sm");  // Aggiungi la classe "text-sm" alla <option>.
                fnInitSelect(parentSel);  // Attach degli eventi custom e personalizzazione del <select>.
            }
        };
        $(".org-level-section-add").on("click", orgAddSection);

        var orgDeleteSection = function(evt) {
            var sectItem = $(this).closest(".org-section-item");
            var sectId = sectItem.data("org-section-id");
            var blk = sectItem.closest(".org-level-blk");

            // Nota: gli id di sezione restano invariati, sono valori univoci locali e nel database saranno
            //       sostituiti dal valore AUTO_INCREMENT generato dalla tabella `section`.
            //       Dopo aver eliminato la sezione, è sufficiente eliminare ogni eventuale reference dai
            //       <select> del blocco inferiore.

            // Chiudi la sezione ed eliminala alla fine dell'animazione "slideUp".
            sectItem.slideUp("slow", function() {
                sectItem.remove();  // Rimuovi la sezione.

                // Elimina l'<option> (della sezione eliminata) da tutti i riferimenti nei <select> per
                // le sezioni parente del livello inferiore.
                blk.next(".org-level-blk").find("select.section-parent").each(function() {
                    var sel = $(this);
                    sel.find("option").filter(function() {
                        // Limita la collection di <option> del <select> corrente all'unica che ha un
                        //   value == sectId.
                        return $(this).prop("value") == sectId;
                    }).remove();

                    // Aggiungi la classe "text-sm" alle <option> del <select> corrente.
                    // Serve un piccolo delay per l'assestamento delle <option>.
                    // Nota: ogni modifica alle <option> di un te.Select ripristina il css di default,
                    //       di conseguenza, la classe "text-sm" va ripristinata.
                    window.setTimeout(function() {
                        var teSel = te.Select.getInstance(sel.get(0));
                        addOptionClasses(teSel, sel, "text-sm");
                    }, 50);
                });

                // Controlla il nome del livello della sezione eliminata (nel caso non ci siano più sezioni).
                blk.find(".org-level-langs input.peer").trigger(eventName);  // Trigger di tutti gli elementi <input.peer>.
            });
        };
        $(".section-trash").on("click", orgDeleteSection);

        // Handler per gli <input> dei nomi di tutti i livelli e tutte le sezioni.
        sectionStrings.find("input.peer").on(eventAll, setLevelSectionName);
        $(".org-level-langs, .org-section-langs").each(function() {
            $(this).find("input.peer").triggerHandler(eventName);  // Trigger solo del primo elemento della collection.
        });

        var sectionsActions = function(url) {
            $("#sections-errors").addClass("hidden").html("");

            // Ottieni le due funzioni di inizializzazione dinamica (se non lo sono già).
            getInitFuncs();

            var processData = true;
            var contentType = "application/x-www-form-urlencoded; charset=UTF-8";

            if (url == "/admin.sections.store") {
                processData = false;  // tell jQuery not to process the data.
                contentType = false;  // tell jQuery not to set contentType.

                // Form-Data di invio.
                var formData = new window.FormData($("form#sections-form").get(0));

                // Aggiungi i dati delle associazioni agli employees (tabella `section_employee`).
                sectionStrings.find(".org-section-item").each(function() {
                    var div = $(this);
                    var emps = div.data("employees");
                    if (emps) {
                        var lvl = div.closest(".org-level-blk").data("org-level-id");
                        var sect = div.data("org-section-id");
                        formData.append("org-employees-" + lvl + "-" + sect, emps);
                    }
                });
            }
            // Invia solo il token, è necessario.
            else var formData = { _token: $("#sections-form input[type=hidden][name=_token]").val() };

            $.ajax({
                type: "post",
                url: url,
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: processData,
                contentType: contentType,
                success: function(data, textStatus, jqXHR) {
                    $("#sections-customer-name").text(data["customer-name"]);

                    // Tramite Ajax viene ritornata la struttura corrente dei livelli e sezioni.
                    // La struttura HTML viene ricostruita rinumerando gli id (sia dei livelli
                    // che delle sezioni) a patire dal valore 1 e incrementandolo.
                    // In fase di "save", gli id incrementali serviranno per iterare la struttura
                    // mantenendo la gerarchia, gli id nel DB saranno generati dagli AUTO_INCREMENT.
                    // L'object 'sectionMap' permette di mappare gli id delle sezioni parente del
                    // DB con l'id locale incrementale.
                    // In fase di "save", gli id incrementali saranno sostituiti con gli id generati
                    // dai rispettivi AUTO_INCREMENT.
                    // In fase di "save", la struttura viene distrutta e ricostruita da capo.
                    // Procedura:
                    //   • DELETE di tutti i livelli del customer corrente dalla tabella `section_level`.
                    //   • tutte le references nelle tabelle `section_level_lang`, `section` e
                    //     `section_level_lang` sono automaticamente eliminate dalla action
                    //     ON DELETE CASCADE).
                    //   • anche eventuali references nella tabella `section_employee` sono eliminate
                    //     automaticamente e vanno ripristinate tramite gli id salvati nell'attributo
                    //     "data-employees" di ogni <div.org-section-item>.
                    //     Gli id degli employees sono utilizzabili as-they-are mentre gli id delle
                    //     sezioni saranno quelli generati dai rispettivi AUTO_INCREMENT.
                    //     Nota: gli id degli employees ("data-employees") sono aggiunti ai dati
                    //           del formData tramite il metodo .append() prima di eseguire la
                    //           richiesta di "save" tramite Ajax.

                    var html = "", sect = 1, sectionMap = { };

                    // Itera i livelli dell'organigramma.
                    for (var level of data.levels) {
                        var lvl = level.level;
                        var lvlLangs = (level.names) ? level.names.split("\f") : [];
                        var lvlLabel = (lvlLangs.length > 0) ? lvlLangs[0].slice(3) : "";

                        var langNames = { };
                        for (var lng of lvlLangs) langNames[lng.slice(0, 2)] = lng.slice(3);

                        html += "<div class=\"org-level-blk\" data-org-level-id=\"" + lvl + "\">" +
                                "<div class=\"org-level-data\" data-title=\"" + levelErrorTooltip + "\">" +
                                "<div class=\"org-level-title\">" +
                                    "<span class=\"level-exp-arrow\"><svg class=\"h-4 w-4 stroke-neutral-800 hover:a4-stroke-shade-300\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M19.5 8.25l-7.5 7.5-7.5-7.5\"></path></svg></span>" +
                                    "<span class=\"level-label\">" + levelLabel + ": <span class=\"level-name\">" + lvlLabel + "</span></span>" +
                                    "<span class=\"level-trash\" title=\"" + levelDeleteTooltip + "\"><svg class=\"w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300\" viewBox=\"0 0 16 16\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\"></path><path fill-rule=\"evenodd\" d=\"M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z\"></path></svg></span>" +
                                "</div>" +
                                "<div class=\"collapse h-0 org-level-langs\">";

                        // Itera le lingue dei nomi del livello corrente.
                        for (var lang of sectionLanguages) {
                            html += "<div class=\"relative mt-1\" data-te-input-wrapper-init=\"\">";

                            var val = (typeof(langNames[lang.code]) != "undefined") ? " value=\"" + langNames[lang.code] + "\"" : "";
                            var id = "\"org-level-" + lvl + "-" + lang.code + "\"";
                            html += "<input id=" + id + " name=" + id + val + " type=\"text\" placeholder=\"" +
                                    lang.label + "\" maxlength=\"64\" class=\"" + inputClasses + "\" />";
                            html += "<label for=" + id + " class=\"" + labelClasses + "\">" + lang.label + "</label></div>";
                        }

                        html += "</div></div><div class=\"org-level-aside\" title=\"" + levelLabel + " " + lvl + "\">" + lvl + "</div>";

                        html += "<div class=\"org-sections-container\">" +
                                "<div class=\"org-sections-info\">" +
                                    "<span class=\"org-sections-label self-center\">" + levelSectionLabel + " " + lvl + "</span>" +
                                    "<span class=\"org-level-section-add cursor-pointer self-center\" title=\"" + addSectionTooltip + "\"><svg class=\"w-6 h-6 fill-neutral-800 hover:a4-fill-shade-300 transition-all duration-300 ease-linear\" viewBox=\"0 0 16 16\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z\"></path><path d=\"M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z\"></path></svg></span>" +
                                "</div>";

                        // Formato dopo il popolamento:
                        //   Il primo livello indica l'indice del livello e contiene la collection delle sue sezioni.
                        //   La collection è referenziata dal proprio indice di sezione e contiene un object con la
                        //   label della sezione (label della relativa <option>) e l'indice incrementale utilizzato
                        //   localmente nel codce HTML, non necessariamente uguale all'indice nel DB ('value' della
                        //   reativa <option>).
                        //
                        //   Esempio:
                        //     {
                        //       "1": { "1": { local: sect, label: sectLabel },
                        //              "2": { local: sect, label: sectLabel } }
                        //
                        //       "2": { "3": { local: sect, label: sectLabel } }
                        sectionMap[lvl] = { };  // Object che verrà popolato con le sezioni del livllo corrente.

                        html += "<div class=\"org-sections-list\">";

                        // Itera le sezioni (unità) del livello corrente.
                        for (var section of data.sections) {
                            if (section.level != lvl) continue;

                            var sectNames = (section.names) ? section.names.split("\f") : [];
                            var sectLabel = (sectNames.length > 0) ? sectNames[0].slice(3) : "";

                            var langSectNames = { };
                            for (var lng of sectNames) langSectNames[lng.slice(0, 2)] = lng.slice(3);

                            // Mappa l'id effettivo della sezione corrente con l'id incrementale locale (nel codice HTML).
                            sectionMap[lvl][section.id] = { local: sect, label: sectLabel };

                            // Salva gli eventuali id degli employees associati alla sezione corrente (tabella `section_employee`).
                            var emps = (section.employees) ? " data-employees=\"" + section.employees + "\"" : "";

                            html += "<div class=\"org-section-item\" data-org-section-id=\"" + sect + "\"" + emps + ">" +
                                    "<div class=\"org-section-data\" data-title=\"" + sectionErrorTooltip + "\">";

                            var cls = (lvl > 1) ? "org-section-parent-title" : "org-section-title";
                            html += "<div class=\"" + cls + "\">" +
                                    "<span class=\"section-exp-arrow\"><svg class=\"h-4 w-4 stroke-neutral-800 hover:a4-stroke-shade-300\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M19.5 8.25l-7.5 7.5-7.5-7.5\"></path></svg></span>" +
                                    "<span class=\"section-label\">" + sectionLabel + ": <span class=\"section-name\">" + sectLabel + "</span></span>";
                            if (lvl > 1) {
                                var id = "\"org-parent-" + lvl + "-" + sect + "\"";

                                html += "<div class=\"section-parent-container\">" +
                                        "<select id=" + id + " name=" + id + " class=\"section-parent\" data-te-select-init=\"\" data-te-select-size=\"sm\" data-te-select-option-height=\"26\" data-te-select-visible-options=\"6\">";

                                // Genera le <option> per tutte le sezioni del livello parente.
                                // Seleziona la <option> in base al parametro 'parent' (colonna
                                // `parent_section_id` della tabella `section`).
                                for (var sc in sectionMap[lvl - 1]) {
                                    var sel = (sc == section.parent) ? " selected" : "";
                                    var sd = sectionMap[lvl - 1][sc];
                                    html += "<option value=\"" + sd.local + "\"" + sel + ">" + sd.label + "</option>";
                                }

                                html += "</select>" +
                                        "<label data-te-select-label-ref=\"\">" + parentSectionLabel + "</label>" +
                                        "</div>";
                            }

                            html += "<span class=\"section-trash\" title=\"" + sectionDeleteTooltip + "\"><svg class=\"w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300\" viewBox=\"0 0 16 16\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\"></path><path fill-rule=\"evenodd\" d=\"M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z\"></path></svg></span>" +
                                    "</div>" +
                                    "<div class=\"collapse h-0 org-section-langs\">";

                            // Itera le lingue dei nomi della sezione corrente.
                            for (var lang of sectionLanguages) {
                                html += "<div class=\"relative mt-1\" data-te-input-wrapper-init=\"\">";

                                var val = (typeof(langSectNames[lang.code]) != "undefined") ? " value=\"" + langSectNames[lang.code] + "\"" : "";
                                var id = "\"org-section-" + lvl + "-" + sect + "-" + lang.code + "\"";
                                html += "<input id=" + id + " name=" + id + val + " type=\"text\" placeholder=\"" +
                                        lang.label + "\" maxlength=\"64\" class=\"" + inputClasses + "\" />" +
                                        "<label for=" + id + " class=\"" + labelClasses + "\">" + lang.label + "</label></div>";
                            }

                            html += "</div></div></div>";

                            sect++;
                        }

                        html += "</div></div></div>";
                    }

                    sectionStrings.html(html);

                    // Itera i <select>.
                    sectionStrings.find("select[data-te-select-init]").each(function() {
                        // Inizializza il <select> del Tailwind element.
                        var teSel = new te.Select(this);
                        addOptionClasses(teSel, $(this), "text-sm");  // Aggiungi la classe "text-sm" alla <option>.
                        fnInitSelect($(this));  // Attach degli eventi custom e personalizzazione del <select>.
                    });

                    var loadLazyData = function() {
                        // Imposta gli handler degli eventi e inizializza gli <input> e i <select> twe.
                        sectionStrings.find(".level-exp-arrow, .section-exp-arrow").on("click", levelSectionExpander);
                        sectionStrings.find(".level-trash").on("click", orgDeleteLevel);
                        sectionStrings.find(".section-trash").on("click", orgDeleteSection);
                        sectionStrings.find(".org-level-section-add").on("click", orgAddSection);

                        // Binding dell'evento hover.
                        sectionStrings.find(".section-label").on("mouseenter", function(evt) { setSectionHover(evt, $(this)); })
                                                             .on("mouseleave", function(evt) { setSectionHover(evt, $(this)); });

                        // Inizializza tutti gli <input> (attach della libreria twe) delle lingue per il nome del livello.
                        sectionStrings.find(".org-level-langs [data-te-input-wrapper-init]," +
                                            ".org-section-langs [data-te-input-wrapper-init]").each(function() {
                            new te.Input(this);  // Inizializza l'<input>.

                            var inp = $(this).find("input.peer");
                            inp.on(eventAll, setLevelSectionName).triggerHandler(eventName);
                            fnInitInput(inp);  // Attach degli eventi custom e personalizzazione dell'<input>.
                        });

                        sectionStrings.find(".org-level-langs, .org-section-langs").css("display", "none")
                                                                                   .removeClass("collapse h-0")
                                                                                   .addClass("py-2");

                        validateSections();
                    }

                    if ($("#sections-block").css("overflow") != "hidden") loadLazyData();
                    else $(document).one("page-loaded:sections", loadLazyData);
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#sections-errors"); }
            });
        };

        // Gestione button "Save" del form "sections-form".
        $("#save-sections").on("click", function(evt) {
            sectionsActions("/admin.sections.store");
        });

        pageLoadCallbacks["load-sections-page"] = function() {
            sectionsActions("/admin.sections.index");
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Employees sections block.

        var validateSectionsEmployees = function() {
            var bName = $("select#employee-section-names").val() !== null;
            var btSave = $("#save-employee-sections");

            // Il button "#save-employee-sections" è abilitato solo se la selezione di
            // <select#employee-section-names> è valida.
            if (bName && btSave.is(":disabled")) btSave.prop("disabled", false);
            else if (!bName && btSave.is(":enabled")) btSave.prop("disabled", true);

            bName = $("select#section-employee-names").val() !== null;
            btSave = $("#save-section-employees");

            // Il button "#save-section-employees" è abilitato solo se la selezione di
            // <select#section-employee-names> è valida.
            if (bName && btSave.is(":disabled")) btSave.prop("disabled", false);
            else if (!bName && btSave.is(":enabled")) btSave.prop("disabled", true);
        }

        var employeesSectionsActions = function(url) {
            $("#employees-sections-errors").addClass("hidden").html("");

            // Form-Data di invio.
            var formData = new window.FormData($("form#employees-sections-form").get(0));

            $.ajax({
                type: "post",
                url: url,
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    var blk = $("#employees-sections-block");
                    blk.find("#empsections-customer-name").text(data["customer-name"]);

                    var loadLazyData = function() {
                        // Popola la lista degli impiegati.
                        var employees = $("#employee-section-names");
                        employees.html(data.employeeOpts).triggerHandler("select:update");
                        updateSelectFilter("#employee-section-names");

                        // Popola la lista delle sezioni da associare all'impiegato selezionato.
                        var sections = $("#section-all-names");
                        sections.html(data.employeeSectsOpts).triggerHandler("select:update");
                        updateSelectFilter("#section-all-names");

                        // Popola la lista delle sezioni.
                        sections = $("#section-employee-names");
                        sections.html(data.sectionOpts).triggerHandler("select:update");
                        updateSelectFilter("#section-employee-names");

                        // Popola la lista degli impiegati da associare alla sezione selezionata.
                        employees = $("#employee-all-names");
                        employees.html(data.sectionEmpsOpts).triggerHandler("select:update");
                        updateSelectFilter("#employee-all-names");

                        validateSectionsEmployees();
                    };

                    // Se la pagina "Employees Sections" è completamente aperta, esegui il caricamento degli impiegati,
                    // altrimenti, attendi che la pagina sia completamente aperta (evento "page-loaded:employees-sections").
                    if (blk.css("overflow") != "hidden") loadLazyData();
                    // Il fadeOut viene eseguito in animateScroll() o nell'handler $(".exp-block .admin-selector").on("click").
                    else $(document).one("page-loaded:employees-sections", loadLazyData);
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#employees-sections-errors"); }
            });
        };

        $("#employee-section-names, #section-employee-names").on("change", function(evt) {
            employeesSectionsActions("/admin.employees-sections.index");
        });

        // Copia gli eventuali tooltip delle <option> dei <select#employee-section-names> e <select#section-employee-names>
        // nel dropdown creato dinamicamente da tw-elements.
        $("#employee-section-names, #section-employee-names").on("open.te.select", function(evt) {
            var sel = $(this);
            var dropdown = $(te.Select.getInstance(sel.get(0))._dropdownContainer);
            var dropOptions = dropdown.find("div[data-te-select-options-list-ref] div[data-te-select-option-ref]");
            sel.find("option").each(function(index) {
                // Il tooltip sorgente è memorizzato nella property "data-title" anziché direttamente nella property "title".
                // In questo modo, si evita che l'evento "change select:update" della funzione doInitSelect() (inputs.js)
                // copi il tootip dalla <option> selezionata nel <select> (sovrascrivendo il tooltip originale).
                var tooltip = $(this).data("title") ?? "";
                if (tooltip.length > 0) dropOptions.eq(index).find("span.group").prop("title", tooltip);
            });
        });

        // Gestione dei button "Save" del form "employees-sections-form".
        $("#save-employee-sections").on("click", function(evt) {
            // Salva le sezioni associate ad un singolo determinato impiegato.
            employeesSectionsActions("/admin.employees-sections.save-employee");
        });

        $("#save-section-employees").on("click", function(evt) {
            // Salva gli impiegati associati ad una singola determinata sezione.
            employeesSectionsActions("/admin.employees-sections.save-section");
        });

        pageLoadCallbacks["load-employees-sections-page"] = function() {
            employeesSectionsActions("/admin.employees-sections.index");
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Tools block.

        var validateTools = function() {
            // Nota: le RegExp per la validazione dei campi "#tools-name-id" e "#tools-title-id" sono
            //       specificati negli attributi "pattern" dei rispettivi <input>.
            var bName = $("select#tools-tool-list").val() !== null;
            var bNameId = $("input#tools-name-id").is(":valid");    // pattern="^A4(?!000$|0000)\d{3,4}$"  Formato: A4nnn (A4000/A40000 non accettato).
            var bTitleId = $("input#tools-title-id").is(":valid");  // pattern="^[A-Za-z]+$"  Formato: solo lettere maiuscole e minuscole.

            var bRequired = $("select#tools-category-level").val().length > 0 &&
                            $("select#tools-category-recipient").val().length > 0 &&
                            $("select#tools-category-usage").val().length > 0;

            var bFields = bNameId && bTitleId && bRequired;

            var btnEdit = $("#edit-tool");
            var btnDelete = $("#delete-tool");
            var btnNew = $("#add-tool");

            // Il button "#delete-tool" è abilitato solo se la selezione del <select#tools-tool-list> è valida.
            if (bName && btnDelete.is(":disabled")) btnDelete.prop("disabled", false);
            else if (!bName && btnDelete.is(":enabled")) btnDelete.prop("disabled", true);

            // Il button "#edit-tool" è abilitato solo se la selezione di <select#tools-tool-list> è valida e
            // se i campi <input#tools-name-id> e <input#tools-title-id> sono validi.
            if (bName && bFields && btnEdit.is(":disabled")) btnEdit.prop("disabled", false);
            else if ((!bName || !bFields) && btnEdit.is(":enabled")) btnEdit.prop("disabled", true);

            // Il button "#add-tool" è abilitato solo se i campi <input#tools-name-id> e <input#tools-title-id> sono validi.
            if (bFields && btnNew.is(":disabled")) btnNew.prop("disabled", false);
            else if (!bFields && btnNew.is(":enabled")) btnNew.prop("disabled", true);
        };

        $("select#tools-category-level, select#tools-category-recipient, select#tools-category-usage").on("change", function(evt) {
            validateTools();
        });

        $("input#tools-name-id, input#tools-title-id").on(eventAll, function(evt) {
            validateTools();
        }).triggerHandler(eventName);  // Trigger solo del primo elemento della collection.

        var toolsActions = function(url, reload) {
            $("#tools-errors").addClass("hidden").html("");

            // Form-Data di invio.
            var formData = new window.FormData($("form#tools-form").get(0));

            // Aggiungi il parametro che indica se la lista dei tool va aggiornata.
            formData.append("reload-tool-names", reload);

            var toolFilter = te.Select.getInstance($("#tools-tool-list").get(0)).filterInput;
            toolFilter = (toolFilter !== null && toolFilter.value.length > 0) ? toolFilter.value : null;

            $.ajax({
                type: "post",
                url: url,
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    var blk = $("#tools-block");

                    var loadLazyData = function() {
                        // Popola la lista dei tools e dei related-tools.
                        if (data.reloaded) {
                            var tools = $("#tools-tool-list");
                            tools.html(data.toolOpts).triggerHandler("select:update");
                            updateSelectFilter("#tools-tool-list", toolFilter);
                        }

                        var relateds = $("#tools-related-tools");
                        relateds.html(data.relatedOpts).triggerHandler("select:update");
                        updateSelectFilter("#tools-related-tools");

                        // Imposta i dati del tool selezionato nei rispettivi widgets.
                        if (data.selected !== "") {
                            var field = blk.find("[data-te-input-wrapper-init] input.peer#tools-name-id");
                            field.val(data.selected["name_id"] ?? "");
                            te.Input.getInstance(field.parent("[data-te-input-wrapper-init]").get(0)).update();
                            field.triggerHandler(eventName);

                            field = blk.find("[data-te-input-wrapper-init] input.peer#tools-title-id");
                            field.val(data.selected["title_id"] ?? "");
                            te.Input.getInstance(field.parent("[data-te-input-wrapper-init]").get(0)).update();
                            field.triggerHandler(eventName);

                            blk.find("input.peer#tools-active").prop("checked", data.selected["active"] == "Y");

                            var sel = blk.find("select#tools-category-level");
                            te.Select.getInstance(sel.get(0)).setValue(data.selected["cat_levels"].split(","));
                            sel.triggerHandler("select:update");

                            sel = blk.find("select#tools-category-recipient");
                            te.Select.getInstance(sel.get(0)).setValue(data.selected["cat_recipients"].split(","));
                            sel.triggerHandler("select:update");

                            sel = blk.find("select#tools-category-usage");
                            te.Select.getInstance(sel.get(0)).setValue(data.selected["cat_usages"].split(","));
                            sel.triggerHandler("select:update");

                            sel = blk.find("select#tools-category-selection");
                            te.Select.getInstance(sel.get(0)).setValue(data.selected["cat_selections"].split(","));
                            sel.triggerHandler("select:update");

                            sel = blk.find("select#tools-category-scope");
                            te.Select.getInstance(sel.get(0)).setValue(data.selected["cat_scopes"]);
                            sel.triggerHandler("select:update");
                        }

                        validateTools();
                    };

                    // Se la pagina "Tools" è completamente aperta, esegui il caricamento dei tools e dei related-tools,
                    // altrimenti, attendi che la pagina sia completamente aperta (evento "page-loaded:tools").
                    if (blk.css("overflow") != "hidden") loadLazyData();
                    // Il fadeOut viene eseguito in animateScroll() o nell'handler $(".exp-block .admin-selector").on("click").
                    else $(document).one("page-loaded:tools", loadLazyData);
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#tools-errors"); }
            });
        };

        $("select#tools-tool-list").on("change", function(evt) {
            // Se la selezione del tool cambia, ricarica i nomi dei tools in modo da aggiornare i related-tools.
            toolsActions("/admin.tools.index", "no");
        });

        // Gestione del button "Modifica" del form "tools-form".
        $("#edit-tool").on("click", function(evt) {
            // Dopo la modifica, ricarica la lista dei tools.
            toolsActions("/admin.tools.edit", "yes");
        });

        // Gestione del button "Elimina" del form "tools-form".
        $("#delete-tool").on("click", function(evt) {
            // Richiama la funzione di utility per la gestione del dialogBox modale di conferma.
            openDeleteItemWarning($(this),
                                  function() {
                                      // Dopo la modifica, ricarica la lista dei tags.
                                      toolsActions("/admin.tools.delete", "yes");
                                  });
        });

        // Gestione del button "Nuovo" del form "tools-form".
        $("#add-tool").on("click", function(evt) {
            // Dopo la modifica, ricarica la lista dei tags.
            toolsActions("/admin.tools.add", "yes");
        });

        var toolListLoaded = "no";
        pageLoadCallbacks["load-tools-page"] = function() {
            toolsActions("/admin.tools.index", (toolListLoaded == "no") ? "yes" : "no");
            toolListLoaded = "yes";
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Tool datas block.

        // Trasforma i <div.data-content.delayed-hidden> in <div> non visibili.
        // Nota: i <select> sono inizialmente visibili (comunque nascosta dagli attributi "collapse"
        //       e "h-0") per permettere il corretto calcolo della parte di bordo trasparente
        //       sotto la label traslata.
        $(".data-content.delayed-hidden").css("display", "none").removeClass("delayed-hidden");

        // Genera il popup utilizzato per visualizzare le stringhe dei <textarea> in formato "markdown".
        $("body").append("<div id=\"preview-popup\"><div class=\"preview-formatting\"></div></div>");

        // Converte una stringa in formato md (Markdown) in una stringa in formato html.
        // Vedi: https://it.wikipedia.org/wiki/Markdown
        //       https://daringfireball.net/projects/markdown
        //       https://daringfireball.net/projects/markdown/syntax
        //       https://github.com/showdownjs/showdown  (contiene la documentazione)
        //       https://showdownjs.com
        var showdownObj = new showdown.Converter();
        showdownObj.setFlavor("github");
        showdownObj.setOption("simpleLineBreaks", false);

        // Gestione del ripristino dell'altezza dei <textarea>.
        // Nota: viene utilizzato un unico object MutationObserver per monitorare tutti i <textarea>
        //       che vengono aggiunti tramite il metodo observe().
        // Vedi: https://developer.mozilla.org/en-US/docs/Web/API/MutationObserver
        var heightObserver = (typeof(MutationObserver) != "undefined") ? new MutationObserver(function(mutationList, observer) {
            for (var mutation of mutationList) {
                if (mutation.type == "attributes" && mutation.attributeName == "style") {
                    var ta = $(mutation.target);
                    var currHeight = ta.height();
                    if (currHeight != ta.data("last-height")) {
                        ta.data("last-height", currHeight);
                        setSessionValue("adm-ta-height-" + ta.prop("id"), currHeight);
                    }
                }
            }
        }) : null;  // heightObserver = null se il browser non supporta la classe MutationObserver.

        // Attiva il monitoring (observer) della property "height" per lo "style" dei <textarea>.
        // Nota: il monitoring viene attivato solo per i textarea che sono ridimensionabili verticalmente.
        $("form#tool-datas-form textarea.resize, form#tool-datas-form textarea.resize-y").each(function() {
            var ta = $(this);
            var height = getSessionValue("adm-ta-height-" + ta.prop("id"));
            if (height !== false) ta.height(height + "px");  // Se un'altezza è memorizzata nello storage, impostala nel <textarea>.
            else height = ta.height();                       // Altrimenti, acquisisci l'altezza corrente (di default).

            ta.data("last-height", height);  // Salva nel "data-last-height" il valore dell'altezza corrente.

            if (heightObserver !== null) {  // Attiva l'observer in comune sul <textarea> corrente.
                heightObserver.observe(this, { attributes: true, attributeFilter: ["style"] });
            }
        });

        // Gestione degli expander.
        var expandDataTooltip = $(".data-blk[data-expand-tooltip]").data("expand-tooltip");
        var collapseDataTooltip = $(".data-blk[data-collapse-tooltip]").data("collapse-tooltip");

        // Gestione del click degli expander.
        $(".data-blk .data-expander").on("click", function(evt) {
            var exp = $(this);
            var expanderName = exp.data("expander-name");
            var status = "close";

            var span = exp.find(".exp-arrow");
            var blk = exp.closest(".data-blk").find(".data-content");

            if (span.hasClass("rotate-[-180deg]")) {
                span.removeClass("rotate-[-180deg]");
                exp.prop("title", expandDataTooltip);
                blk.slideUp("slow");
            }
            else {
                span.addClass("rotate-[-180deg]");
                exp.prop("title", collapseDataTooltip);
                blk.slideDown("slow");

                status = "open";
            }

            // Salva nello storage lo stato dell'expander corrente.
            setSessionValue("datas-exp-" + expanderName, status);
        }).each(function() {
            var exp = $(this);
            var status = getSessionValue("datas-exp-" + exp.data("expander-name"));
            if (status == "open") exp.triggerHandler("click");
        });

        // Gestione dell'evento "click" per l'icona ".data-preview".
        var mdPopupPreview = $("#preview-popup");
        $(".data-preview").on("click", function(evt) {
            var ta = $(this).closest(".data-text-container").find("textarea");
            if (ta.val().trim().length <= 0) return;

            var taCont = ta.parent("div[data-te-input-wrapper-init]");
            var lbl = taCont.find("label");
            var lblPad = lbl.innerHeight() - lbl.height();  // Determina il padding-top della label.
            var top = lbl.offset().top;
            var pos = taCont.offset();

            // Se la <label> è traslata sulla parte del bordo in alto a sinistra, calcola la differenza
            // necessaria per coprirla con il popup di preview.
            var diff = (top < pos.top) ? (pos.top - top) - lblPad : 1;

            // Imposta il contenuto html ottenuto dal testo Markdown.
            mdPopupPreview.find(".preview-formatting").html(showdownObj.makeHtml(ta.val()));

            // Posiziona il popup di preview.
            mdPopupPreview.css({ left: (pos.left - 1) + "px", top: (pos.top - diff) + "px" })
                          .width(taCont.width()).height(taCont.innerHeight() + (diff - 1))
                          .slideDown("fast");

            // Chiudi il popup quando il cursore del mouse esce dall'area del contenitore del <textarea>.
            // Nota: se l'evento "mouseleave" è invocato con un relatedTarget corrispondente a <div#preview-popup>,
            //       allora l'evento "mouseleave" è provocato dal cursore del mouse che è entrato nell'area
            //       del popup di preview.
            //       In tal caso, non chiudere il popup, ma delega la sua chiusura all'evento "mouseleave"
            //       del popup stesso.
            $(this).closest(".data-text-container").one("mouseleave", function(evt) {
                if (!$(evt.relatedTarget).is("#preview-popup")) mdPopupPreview.slideUp("fast");
                else mdPopupPreview.one("mouseleave", function(evt) {
                    mdPopupPreview.slideUp("fast");
                });
            });
        });

        // Ripristina lo stato di wrap dei <textarea>.
        $("form#tool-datas-form textarea").each(function() {
            var ta = $(this);
            var wrap = getSessionValue("adm-ta-wrap-" + ta.prop("id"));
            if (wrap && wrap == "wrap") {
                ta.removeClass("whitespace-pre");
                ta.closest(".data-text-container").find(".data-word-wrap svg").removeClass("fill-neutral-800")
                                                                              .addClass("a4-fill-dark-red");
            }
        });

        // Gestione del word-wrap toggle.
        $(".data-word-wrap").on("click", function(evt) {
            // https://developer.mozilla.org/en-US/docs/Web/CSS/white-space
            var span = $(this);
            var svg = span.find("svg");
            var ta = span.closest(".data-text-container").find("textarea");

            var sel = svg.hasClass("a4-fill-dark-red");
            (sel) ? ta.addClass("whitespace-pre") : ta.removeClass("whitespace-pre");

            if (sel) svg.removeClass("a4-fill-dark-red").addClass("fill-neutral-800");
            else svg.removeClass("fill-neutral-800").addClass("a4-fill-dark-red");

            if (sel) deleteSessionKey("adm-ta-wrap-" + ta.prop("id"));
            else setSessionValue("adm-ta-wrap-" + ta.prop("id"), "wrap");
        });

        // Gestione del ripristino dell'altezza di default dei <textarea> (reset).
        $(".data-reset-height").on("click", function(evt) {
            var ta = $(this).closest(".data-text-container").find("textarea");
            if (ta.length <= 0) return;

            deleteSessionKey("adm-ta-height-" + ta.prop("id"));
            ta.css("height", "");
            if (typeof(ta.attr("style")) == "string" && ta.attr("style").length <= 0) {
                ta.removeAttr("style").removeProp("style");
            }
        });

        $("#tool-datas-tool, #tool-datas-lang").on("change", function(evt) {
            toolDatasActions("/admin.tool-datas.index", "no");
        });

        var toolDatasActions = function(url, reload) {
            $("#tool-datas-errors").addClass("hidden").html("");

            // Form-Data di invio.
            var formData = new window.FormData($("form#tool-datas-form").get(0));

            // Aggiungi il parametro che indica se la lista dei tool va aggiornata.
            formData.append("reload-tool-names", reload);

            $.ajax({
                type: "post",
                url: url,
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    var cols = [
                        { "col": "alphabetical_index", "id": "data-alphabetical-index" },
                        { "col": "sub_title", "id": "data-subtitle" },
                        { "col": "introduction", "id": "data-introduction" },
                        { "col": "presentation", "id": "data-presentation" },
                        { "col": "potential", "id": "data-potential" },
                        { "col": "solved_problem", "id": "data-solved-problem" },
                        { "col": "instructions", "id": "data-instructions-for-use" },
                        { "col": "advanced_techniques", "id": "data-advanced-techniques" },
                        { "col": "risks_and_remedies", "id": "data-risks-and-remedies" },
                        { "col": "mistakes", "id": "data-mistakes" },
                        { "col": "insight_1", "id": "data-insight-1" },
                        { "col": "insight_2", "id": "data-insight-2" },
                        { "col": "insight_3", "id": "data-insight-3" },
                        { "col": "insight_4", "id": "data-insight-4" },
                        { "col": "insight_5", "id": "data-insight-5" },
                        { "col": "provocation_1", "id": "data-provocation-1" },
                        { "col": "provocation_2", "id": "data-provocation-2" },
                        { "col": "opportunities", "id": "data-opportunities" },
                        { "col": "key_results", "id": "data-key-results" }
                    ];

                    var blk = $("#tool-datas-block");

                    var loadLazyData = function() {
                        // Popola la lista dei tools e dei related-tools.
                        if (data.reloaded) {
                            var tools = $("#tool-datas-tool");
                            tools.html(data.toolOpts).triggerHandler("select:update");
                            updateSelectFilter("#tool-datas-tool");
                        }

                        for (var map of cols) {
                            var val = data.datas[map.col] ?? "";

                            var ta = $("#" + map.id);
                            var prevVal = ta.val();
                            ta.val(val);
                            te.Input.getInstance(ta.parent("[data-te-input-wrapper-init]").get(0)).update();

                            // Se il testo del textarea delle è empty, serve temporaneamente il focus
                            // per aggiornare la posizione della label (workaround).
                            // Nota: l'assegnazione temporanea del focus è necessaria solo per la transizione
                            //       del contenuto da not-empty a empty.
                            if (val.length <= 0 && prevVal.length > 0) {
                                ta.get(0).focus({ preventScroll: true });
                                ta.trigger("blur");
                            }
                        }
                    };

                    // Se la pagina "Tool Datas" è completamente aperta, esegui il caricamento dei tools e dei suoi dati,
                    // altrimenti, attendi che la pagina sia completamente aperta (evento "page-loaded:tool-datas").
                    if (blk.css("overflow") != "hidden") loadLazyData();
                    // Il fadeOut viene eseguito in animateScroll() o nell'handler $(".exp-block .admin-selector").on("click").
                    else $(document).one("page-loaded:tool-datas", loadLazyData);
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#tool-datas-errors"); }
            });
        };

        // Gestione del button "Salva" del form "tool-datas-form".
        $("#save-tool-datas").on("click", function(evt) {
            toolDatasActions("/admin.tool-datas.store", "no");
        });

        pageLoadCallbacks["load-tool-datas-page"] = function() {
            toolDatasActions("/admin.tool-datas.index", "yes");
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Personal tools block.

        var personalToolsOneTime = function() {
            // Il metodo .one() esegue l'unbind dell'evento "show.te.dropdown" dopo la
            // prima volta che viene aperto il dropdown "#dropdown-personal-tools-tools".
            // Inizializza tutti i <select.pers-emp-tool-selector> ed esegui il bind
            // dell'evento "open.te.select" per tutti i <select.select.pers-emp-tool-selector>.

            // Itera tutti i <select.pers-emp-tool-selector>.
            $("#employee-personal-tools-block select.pers-emp-tool-selector").each(function() {
                var sel = $(this);
                var wrapper = sel.closest("[data-te-select-wrapper-ref]");
                var outline = wrapper.find("[data-te-select-form-outline-ref]");

                wrapper.addClass("w-11");
                var inp = outline.find("input[data-te-select-input-ref]");
                inp.removeClass("pl-3 pr-8").addClass("pl-1.5 pr-5");
                outline.find("span.absolute").removeClass("w-5 h-5 right-3").addClass("w-4 h-4 right-1");

                // Imposta la classe effettiva della label relativa all'impostazione dei ogni <select.pers-emp-tool-selector>.
                var vl = sel.find("option:selected").val();
                sel.closest(".select-sm-cont").next("div").removeClass("tool-yes tool-no tool-disabled")
                                                          .addClass("tool-" + vl);

                // Quando il dropdown del <select> sta per essere aperto, inizializzalo.
                // Nota: il dropdown del <select> viene creato all'apertura e distrutto alla chiusura,
                //       quindi l'inizializzazione va fatta ad ogni apertura.
                sel.on("open.te.select", function(evt) {
                    var _sel = $(this);  // Closure di 'sel' utilizzata all'interno di setTimeout().

                    // Ritarda l'inizializzazione per dare il tempo al dropdown di essere creato.
                    // Nota: purtroppo non esiste l'evento triggerato DOPO che il dropdown è stato creato.
                    window.setTimeout(function() {
                        var container = $("div[data-te-select-dropdown-container-ref]");
                        var dropdown = container.find("div[data-te-select-dropdown-ref]");
                        var cls = /\b(min-w-\S+)/.exec(dropdown.prop("className"));
                        if (cls !== null) dropdown.removeClass(cls[1]);

                        dropdown.find("div[data-te-select-options-wrapper-ref]").on("click", function(evt) {
                            // Evita che il dropdown dei tools ("#dropdown-personal-tools-tools") si chiuda
                            // quando viene chiuso il dropdown di un <select.pers-emp-tool-selector>.
                            evt.stopPropagation();
                        });

                        // Copia i tooltip delle <option> dei <select.pers-emp-tool-selector> nel rispettivi
                        // dropdown creati dinamicamente da tw-elements.
                        var items = dropdown.find("div[data-te-select-option-ref]");
                        var opts = _sel.find("option");
                        items.each(function(index) {
                            $(this).prop("title", opts.eq(index).prop("title"));
                        }).addClass("text-xs").find("span[data-te-select-option-text-ref]").addClass("mx-auto");

                        cls = /\b(px-\S+)/.exec(items.prop("className"));
                        if (cls !== null) items.removeClass(cls[1]);
                    }, 20);
                }).on("change", function(evt) {
                    // Il tooltip della <option> selezionata è già copiata nell'<input> del <select> dallo script "inputs.js".
                    var vl = $(this).find("option:selected").val();
                    $(this).closest(".select-sm-cont").next("div").removeClass("tool-yes tool-no tool-disabled")
                                                                  .addClass("tool-" + vl);
                });
            });
        };

        var personalToolsActions = function(url) {
            $("#personal-tools-errors").addClass("hidden").html("");

            // Form-Data di invio.
            var formData = new window.FormData($("form#personal-tools-form").get(0));

            $.ajax({
                type: "post",
                url: url,
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    var blk = $("#personal-tools-block");

                    var loadLazyData = function() {
                        // Popola la lista degli impiegati.
                        var employees = $("#personal-tool-employee-names");
                        employees.html(data.employeeOpts).triggerHandler("select:update");
                        updateSelectFilter("#personal-tool-employee-names");

                        // Ottieni le due funzioni di inizializzazione dinamica (se non lo sono già).
                        getInitFuncs();

                        // Popola il dropdown dei tools ed inizializza tutti i rispettivi <select> di stato.
                        $("#personal-tools-dropdown").html(data.toolOpts)
                                                     .find(".pers-emp-tool-selector").each(function() {
                            new te.Select(this);    // Inizializza il <select>.
                            fnInitSelect($(this));  // Attach degli eventi custom e personalizzazione del <select>.
                        });

                        // Imposta l'handler one-time dopo che il nuovo contenuto impostato con il metodo
                        // .html() ha distrutto gli handler impostati internamente al suo interno.
                        $("#dropdown-personal-tools-tools").one("show.te.dropdown", personalToolsOneTime);
                    };

                    // Se la pagina "Personal Tools" è completamente aperta, esegui il caricamento degli impiegati,
                    // altrimenti, attendi che la pagina sia completamente aperta (evento "page-loaded:personal-tools").
                    if (blk.css("overflow") != "hidden") loadLazyData();
                    // Il fadeOut viene eseguito in animateScroll() o nell'handler $(".exp-block .admin-selector").on("click").
                    else $(document).one("page-loaded:personal-tools", loadLazyData);
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#personal-tools-errors"); }
            });
        };

        // Gestione button "Save" del form "personal-tools-form".
        $("#save-personal-tools").on("click", function(evt) {
            // Controlla se si stanno per salvare delle impostazioni che eliminano delle entries della
            // tabella `employee_personal_tool`, se l'eliminazione di almeno una di queste entries
            // provoca anche l'eliminazione di relativi 'personal_job' (ON DELETE CASCADE), chiedi
            // conferma.
            var lbl = $("#dropdown-personal-tools-tools").next("ul").find(".select-sm-cont").next("div");
            var warnList = lbl.filter(".tool-no[data-have-jobs]");
            if (warnList.length > 0) {
                var list = "";
                warnList.each(function(index) {
                    if (index > 0) list += "<br />";
                    list += $(this).prop("title");
                });

                $("#personal-tool-warning [data-te-modal-body-ref] .warning-list").html(list);
                (new te.Modal($("#personal-tool-warning").get(0))).show();
            }
            else $("#close-personal-tool-warning").triggerHandler("click");
        });
        $("#close-personal-tool-warning").on("click", function(evt) {  // Button di "Save" nel dialogBox modale "#dropdown-personal-tools-tools".
            personalToolsActions("/admin.personal-tools.store");
        });

        $("#personal-tool-employee-names").on("change", function(evt) {
            personalToolsActions("/admin.personal-tools.index");
        });

        pageLoadCallbacks["load-personal-tools-page"] = function() {
            personalToolsActions("/admin.personal-tools.index");
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Tags tools block.

        var validateTags = function(evt) {
            var bName = $("select#tag-names").val() !== null;

            // Determina se è stata compilata almeno una lingua per il nome del tag.
            var bTagName = false;
            var blk = $("#tag-langs");
            blk.find("input.peer").each(function() {
                if ($(this).val().trim().length > 0) {
                    bTagName = true;
                    return false;  // Termina l'iterazione di each().
                }
            });

            (bTagName) ? blk.removeClass(bgError) : blk.addClass(bgError);

            var btnEdit = $("#edit-tag");
            var btnDelete = $("#delete-tag");
            var btnNew = $("#add-tag");

            // Il button "#delete-tag" è abilitato solo se la selezione del <select#tag-names> è valida.
            if (bName && btnDelete.is(":disabled")) btnDelete.prop("disabled", false);
            else if (!bName && btnDelete.is(":enabled")) btnDelete.prop("disabled", true);

            // Il button "#edit-tag" è abilitato solo se la selezione di <select#tag-names> è valida
            // ed è stata compilata almeno una lingua per il nome del tag.
            if (bName && bTagName && btnEdit.is(":disabled")) btnEdit.prop("disabled", false);
            else if ((!bName || !bTagName) && btnEdit.is(":enabled")) btnEdit.prop("disabled", true);

            // Il button "#add-tag" è abilitato solo se è stata compilata almeno una lingua per il nome del tag.
            if (bTagName && btnNew.is(":disabled")) btnNew.prop("disabled", false);
            else if (!bTagName && btnNew.is(":enabled")) btnNew.prop("disabled", true);
        };

        $("#tag-langs input.peer").on(eventAll, function(evt) {
            validateTags(evt);
        }).triggerHandler(eventName);  // Trigger solo del primo elemento della collection.

        var tagsActions = function(url, reload) {
            $("#tags-errors").addClass("hidden").html("");

            // Form-Data di invio.
            var formData = new window.FormData($("form#tags-form").get(0));

            // Aggiungi il parametro che indica se la lista dei tag va aggiornata.
            formData.append("reload-tag-names", reload);

            $.ajax({
                type: "post",
                url: url,
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    // Popola il <select#tag-tool-names> se non lo è già.
                    if (data.reloaded) {
                        var tagNames = $("#tag-tool-names");
                        tagNames.html(data.tagOpts).triggerHandler("select:update");
                        updateSelectFilter("#tag-tool-names");
                    }

                    // Aggiorna gli input dei nomi multilingua con i nomi del tag selezionato.
                    var langInput = $("#tag-langs input.peer");
                    langInput.val("");  // Empty di tutte le lingue.
                    var tagNames = (data.selectedTag.length > 0) ? data.selectedTag.split("\f") : [];

                    // Imposta i nuovi nomi specificati per il tag selezionato.
                    for (var nameLang of tagNames) {
                        var lang = nameLang.split(":");
                        if (lang.length > 1 && lang[0].length == 2) {
                            var inp = $("#tag-name-" + lang[0]);
                            inp.val(nameLang.slice(3));
                        }
                    }

                    // Aggiorna tutti gli input delle lingue.
                    langInput.each(function() {
                        te.Input.getInstance($(this).parent("[data-te-input-wrapper-init]").get(0)).update();
                    }).trigger(eventName);
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#tags-errors"); }
            });
        };

        $("#tag-tool-names").on("change", function(evt) {
            tagsActions("/admin.tags.index", "no");
        });

        // Gestione del button "Modifica" del form "tags-form".
        $("#edit-tag").on("click", function(evt) {
            // Dopo la modifica, ricarica la lista dei tags.
            tagsActions("/admin.tags.edit", "yes");
        });

        // Gestione del button "Elimina" del form "tags-form".
        $("#delete-tag").on("click", function(evt) {
            // Richiama la funzione di utility per la gestione del dialogBox modale di conferma.
            openDeleteItemWarning($(this),
                                  function() {
                                      // Dopo la modifica, ricarica la lista dei tags.
                                      tagsActions("/admin.tags.delete", "yes");
                                  });
        });

        // Gestione del button "Nuovo" del form "tags-form".
        $("#add-tag").on("click", function(evt) {
            // Dopo la modifica, ricarica la lista dei tags.
            tagsActions("/admin.tags.add", "yes");
        });

        var tagListLoaded = "no";
        pageLoadCallbacks["load-tags-page"] = function() {
            tagsActions("/admin.tags.index", (tagListLoaded == "no") ? "yes" : "no");
            tagListLoaded = "yes";
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Tools Tags block.

        var validateToolsTags = function() {
            var bName = $("select#tool-to-tag-names").val() !== null;
            var btSave = $("#save-tool-tags");

            // Il button "#save-tool-tags" è abilitato solo se la selezione di
            // <select#tool-to-tag-names> è valida.
            if (bName && btSave.is(":disabled")) btSave.prop("disabled", false);
            else if (!bName && btSave.is(":enabled")) btSave.prop("disabled", true);

            bName = $("select#tag-to-tool-names").val() !== null;
            btSave = $("#save-tag-tools");

            // Il button "#save-tag-tools" è abilitato solo se la selezione di
            // <select#tag-to-tool-names> è valida.
            if (bName && btSave.is(":disabled")) btSave.prop("disabled", false);
            else if (!bName && btSave.is(":enabled")) btSave.prop("disabled", true);
        }

        var toolsTagsActions = function(url) {
            $("#tools-tags-errors").addClass("hidden").html("");

            // Form-Data di invio.
            var formData = new window.FormData($("form#tools-tags-form").get(0));

            $.ajax({
                type: "post",
                url: url,
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    var blk = $("#tools-tags-block");

                    var loadLazyData = function() {
                        // Popola la lista dei tools.
                        var tools = $("#tool-to-tag-names");
                        tools.html(data.toolOpts).triggerHandler("select:update");
                        updateSelectFilter("#tool-to-tag-names");

                        // Popola la lista dei tags da associare al tool selezionato.
                        $("#tool-tags-dropdown").html(data.toolTagsOpts);
                        $("#tool-tags-dropdown .tools-tags-check").on("click", toolsTagsCheckboxes);
                        $("#tool-tags-dropdown .tag-weight-range").on("input", toolsTagsWeights);

                        // Info della lista dei tags associati al tool selezionato.
                        $("#tags-info").text(data.tagsInfo);

                        // Popola la lista dei tags.
                        var tags = $("#tag-to-tool-names");
                        tags.html(data.tagOpts).triggerHandler("select:update");
                        updateSelectFilter("#tag-to-tool-names");

                        // Popola la lista dei tools da associare al tag selezionato.
                        $("#tag-tools-dropdown").html(data.tagToolsOpts);
                        $("#tag-tools-dropdown .tools-tags-check").on("click", toolsTagsCheckboxes);
                        $("#tag-tools-dropdown .tag-weight-range").on("input", toolsTagsWeights);

                        // Info della lista dei tools associati al tag selezionato.
                        $("#tools-info").text(data.toolsInfo);

                        validateToolsTags();
                    };

                    // Se la pagina "Tools Tags" è completamente aperta, esegui il caricamento dei tools/tags,
                    // altrimenti, attendi che la pagina sia completamente aperta (evento "page-loaded:tools-tags").
                    if (blk.css("overflow") != "hidden") loadLazyData();
                    // Il fadeOut viene eseguito in animateScroll() o nell'handler $(".exp-block .admin-selector").on("click").
                    else $(document).one("page-loaded:tools-tags", loadLazyData);
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#tools-tags-errors"); }
            });
        };

        var toolsTagsCheckboxes = function() {
            var check = $(this);
            var checked = check.is(":checked");
            check.closest("li").find(".tag-weight-range").prop("disabled", !checked);
        };

        var toolsTagsWeights = function() {
            var check = $(this);
            check.next("label").text((check.val() + ".0").slice(0, 3));
        };

        $("#tool-to-tag-names, #tag-to-tool-names").on("change", function(evt) {
            toolsTagsActions("/admin.tools-tags.index");
        });

        // Gestione dei button "Save" del form "tools-tags-form".
        $("#save-tool-tags").on("click", function(evt) {
            toolsTagsActions("/admin.tools-tags.save-tool");
        });

        // Gestione dei button "Save" del form "tag-tools-form".
        $("#save-tag-tools").on("click", function(evt) {
            toolsTagsActions("/admin.tools-tags.save-tag");
        });

        pageLoadCallbacks["load-tools-tags-page"] = function() {
            toolsTagsActions("/admin.tools-tags.index");
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Languages block.

        var validateLanguages = function(evt) {
            var bNames = $("select#language-names").val() !== null;

            // Determina se sono stati compilati correttamente tutti i campi della lingua.
            var inpName = $("#language-name");
            var bName = inpName.is(":valid");                // pattern="^\s*[a-zA-Z].*$".
            var bCode = $("#language-code").is(":valid");    // pattern="^[a-z]{2}$".
            var bOrder = $("#language-order").is(":valid");  // min="1".

            var bFields = bName && bCode && bOrder;

            inpName.prop("title", (bName) ? "" : inpName.data("title"));

            var blk = $("#language-data");
            (bFields) ? blk.removeClass(bgError) : blk.addClass(bgError);

            var btnEdit = $("#edit-language");
            var btnDelete = $("#delete-language");
            var btnNew = $("#add-language");

            // Il button "#delete-language" è abilitato solo se la selezione del <select#language-names> è valida.
            if (bNames && btnDelete.is(":disabled")) btnDelete.prop("disabled", false);
            else if (!bNames && btnDelete.is(":enabled")) btnDelete.prop("disabled", true);

            // Il button "#edit-language" è abilitato solo se la selezione di <select#language-names> è valida
            // e sono stati compilati correttamente tutti i campi della lingua.
            if (bNames && bFields && btnEdit.is(":disabled")) btnEdit.prop("disabled", false);
            else if ((!bNames || !bFields) && btnEdit.is(":enabled")) btnEdit.prop("disabled", true);

            // Il button "#add-language" è abilitato solo se sono stati compilati correttamente tutti i campi della lingua.
            if (bFields && btnNew.is(":disabled")) btnNew.prop("disabled", false);
            else if (!bFields && btnNew.is(":enabled")) btnNew.prop("disabled", true);
        };

        var languagesActions = function(url) {
            $("#languages-errors").addClass("hidden").html("");

            // Form-Data di invio.
            var formData = new window.FormData($("form#languages-form").get(0));

            $.ajax({
                type: "post",
                url: url,
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    var fields = ["code", "name", "order"];
                    var blk = $("#languages-block");

                    var loadLazyData = function() {
                        // Se la tabella `language` è stata modificata con successo, ricarica la pagina.
                        if (url.slice(-6) != ".index") {
                            location.reload();
                            return;
                        }

                        // Popola la lista delle lingue.
                        var tools = $("#language-names");
                        tools.html(data.languageOpts).triggerHandler("select:update");
                        updateSelectFilter("#language-names");

                        for (var name of fields) {
                            var field = blk.find("[data-te-input-wrapper-init] input.peer#language-" + name);
                            var val = data.selected[name] ?? "";
                            field.val(val);
                            te.Input.getInstance(field.parent("[data-te-input-wrapper-init]").get(0)).update();
                        }

                        // Il metodo val() non triggera l'evento "input" (inputs.js), invoca esplicitamente l'handler
                        // per l'evento 'eventName' (all'occorrenza, al termine dello slideDown() della pagina corrente).
                        blk.find("[data-te-input-wrapper-init] input.peer").trigger(eventName);

                        validateLanguages();
                    };

                    // Se la pagina "Languages" è completamente aperta, esegui il caricamento delle lingue,
                    // altrimenti, attendi che la pagina sia completamente aperta (evento "page-loaded:languages").
                    if (blk.css("overflow") != "hidden") loadLazyData();
                    // Il fadeOut viene eseguito in animateScroll() o nell'handler $(".exp-block .admin-selector").on("click").
                    else $(document).one("page-loaded:languages", loadLazyData);
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#languages-errors"); }
            });
        };

        $("input#language-name, input#language-code, input#language-order").on(eventAll, function(evt) {
            validateLanguages(evt);
        }).triggerHandler(eventName);  // Trigger solo del primo elemento della collection.

        $("#language-names").on("change", function(evt) {
            languagesActions("/admin.languages.index");
        });

        // Gestione del button "Modifica" del form "languages-form".
        $("#edit-language").on("click", function(evt) {
            languagesActions("/admin.languages.edit");
        });

        // Gestione del button "Elimina" del form "languages-form".
        $("#delete-language").on("click", function(evt) {
            // Richiama la funzione di utility per la gestione del dialogBox modale di conferma.
            openDeleteItemWarning($(this),
                                  function() {
                                      // Dopo la modifica, ricarica la lista delle lingue.
                                      languagesActions("/admin.languages.delete");
                                  });
        });

        // Gestione del button "Nuovo" del form "languages-form".
        $("#add-language").on("click", function(evt) {
            languagesActions("/admin.languages.add");
        });

        pageLoadCallbacks["load-languages-page"] = function() {
            languagesActions("/admin.languages.index");
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Inspire me block.

        var validateInspireMe = function() {
            // Determina se è stata compilata almeno una lingua per le frasi di "ispirami".
            var bFields = false;
            var blk = $("#inspire-langs");
            blk.find("textarea.peer").each(function() {
                if ($(this).val().trim().length > 0) {
                    bFields = true;
                    return false;  // Termina l'iterazione di each().
                }
            });

            (bFields) ? blk.removeClass(bgError) : blk.addClass(bgError);
            var btnSave = $("#save-inspire-me");

            // Il button "#save-inspire-me" è abilitato solo almeno una lingua delle frasi di "ispirami" è valida.
            if (bFields && btnSave.is(":disabled")) btnSave.prop("disabled", false);
            else if (!bFields && btnSave.is(":enabled")) btnSave.prop("disabled", true);
        };

        $("#inspire-langs textarea.peer").on(eventAll, function(evt) {
            validateInspireMe();
        }).triggerHandler(eventName);  // Trigger solo del primo elemento della collection.

        var inspireMeActions = function(url) {
            $("#inspire-me-errors").addClass("hidden").html("");

            // Form-Data di invio.
            var formData = new window.FormData($("form#inspire-me-form").get(0));

            $.ajax({
                type: "post",
                url: url,
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                    var blk = $("#inspire-me-block");

                    var loadLazyData = function() {
                        // Popola l'object 'langCodes' (<langCode>: <value>).
                        var langCodes = { };
                        for (var inspire of data.inspireMe) {
                            langCodes[inspire.lang_code] = inspire.entries;
                        }

                        // Itera i <textarea> presenti nella pagina "Inspire Me".
                        var langs = blk.find("#inspire-langs");
                        langs.find("[data-te-input-wrapper-init] textarea").each(function() {
                            var ta = $(this);
                            var code = /^inspire-me-([a-z]{2})$/.exec(ta.prop("id"))[1];  // langCode del <textarea>.

                            // Se esiste un valore valido per il <textarea> corrente, impostalo.
                            if (typeof(langCodes[code]) != "undefined" && langCodes[code].length > 0) {
                                ta.val(langCodes[code]);  // Nuovo contenuto.
                                te.Input.getInstance(ta.parent("[data-te-input-wrapper-init]").get(0)).update();
                            }
                            else {
                                var prevVal = ta.val();  // Contenuto attuale del <textarea>.
                                ta.val("");
                                te.Input.getInstance(ta.parent("[data-te-input-wrapper-init]").get(0)).update();

                                // Se in precedenza il <textarea> aveva un valore not-empty, assegna temporaneamente
                                // il focus per aggiornare la posizione della label (workaround).
                                // Nota: l'assegnazione temporanea del focus è necessaria solo per la transizione
                                //       del contenuto da not-empty a empty.
                                if (prevVal.length > 0) {
                                    ta.get(0).focus({ preventScroll: true });
                                    ta.trigger("blur");
                                }
                            }
                        });

                        validateInspireMe();
                    };

                    // Se la pagina "Inspire Me" è completamente aperta, esegui il caricamento delle stringhe,
                    // altrimenti, attendi che la pagina sia completamente aperta (evento "page-loaded:inspire-me").
                    if (blk.css("overflow") != "hidden") loadLazyData();
                    // Il fadeOut viene eseguito in animateScroll() o nell'handler $(".exp-block .admin-selector").on("click").
                    else $(document).one("page-loaded:inspire-me", loadLazyData);
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#inspire-me-errors"); }
            });
        };

        // Gestione dei button "Save" del form "inspire-me-form".
        $("#save-inspire-me").on("click", function(evt) {
            inspireMeActions("/admin.inspire-me.store");
        });

        pageLoadCallbacks["load-inspire-me-page"] = function() {
            inspireMeActions("/admin.inspire-me.index");
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Global options block.

        // Inizializza il datetimepicker.
        $.datetimepicker.setLocale($("#date-time-data").data("dt-lang"));
        var dtObj = {
            format: "Y-m-d H:i",  // Formato fisso: MySQL.
            formatDate: "Y-m-d",
            formatTime: "H:i",
            dayOfWeekStart: 1,  // Primo giorno della settimana: 0=domenica, 1=lunedì.
            step: 5,
            mask: true,
            onChangeDateTime: function(dt, input) { input.triggerHandler(eventName); }
        };

        var pdtStart = $("#glb-maintenance-period-start");
        var pdtEnd = $("#glb-maintenance-period-end");
        pdtStart.datetimepicker(dtObj);
        pdtEnd.datetimepicker(dtObj);

        var validateGlobalOption = function(evt) {
            // Aggiorna lo stato di 'enabled' del button '#save-global-options'.
            // Nota: gli input sono di tipo type="number" e sono validati automaticamente.
            var btnSave = $("#save-global-options");

            var inpTimeout = $("#glb-signup-pending-timeout");
            var bTimeout = inpTimeout.is(":valid");
            var inpMinPwLength = $("#glb-minimum-password-length");
            var bMinPwLength = inpMinPwLength.is(":valid");
            var inpMaxPwFailure = $("#glb-max-password-failures");
            var bMaxPwFailure = inpMaxPwFailure.is(":valid");
            var inpRecovering = $("#glb-recovering-access-delay");
            var bRecovering = inpRecovering.is(":valid");
            var inpSupport = $("#glb-support-admin-email");
            var bSupport = inpSupport.is(":valid");

            var bValid = bTimeout && bMinPwLength && bMaxPwFailure && bRecovering && bSupport;

            inpTimeout.prop("title", (bTimeout) ? "" : inpTimeout.data("title"));
            inpMinPwLength.prop("title", (bMinPwLength) ? "" : inpMinPwLength.data("title"));
            inpMaxPwFailure.prop("title", inpMaxPwFailure.data((bMaxPwFailure) ? "title" : "title-error"));
            inpRecovering.prop("title", inpRecovering.data((bRecovering) ? "title" : "title-error"));
            inpSupport.prop("title", (bSupport) ? "" : inpSupport.data("title"));

            var inpUrl = $("#glb-redirect-url");
            if ($("#glb-under-maintenance").val() == "redirect") {
                // Se l'opzione "redirect" è selezionata, l'URL di redirezione deve essere valido.
                inpUrl.attr("aria-required", true).attr("required", "required");
                if (inpUrl.is(":invalid")) bValid = false;
            }
            else inpUrl.removeAttr("aria-required").removeAttr("required");

            if ($("#glb-maintenance-banner").val() == "Y") {
                // Se l'opzione "Y" (show banner) è selezionata, i datetime di inizio e fine
                // devono essere validi.
                var bStart = pdtStart.val().match(/^\s*\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}\s*$/) !== null;
                (bStart) ? pdtStart.removeAttr("aria-required").removeAttr("required") :
                           pdtStart.attr("aria-required", "true").attr("required", "required");

                var bEnd = pdtEnd.val().match(/^\s*\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}\s*$/) !== null;
                (bEnd) ? pdtEnd.removeAttr("aria-required").removeAttr("required") :
                         pdtEnd.attr("aria-required", "true").attr("required", "required");

                if (!bStart || !bEnd) bValid = false;
            }
            else {
                pdtStart.removeAttr("aria-required").removeAttr("required");
                pdtEnd.removeAttr("aria-required").removeAttr("required");
            }

            if (bValid && btnSave.is(":disabled")) btnSave.prop("disabled", false);
            else if (!bValid && btnSave.is(":enabled")) btnSave.prop("disabled", true);
        };

        // Bind dell'handler per gli input "required", l'URL di redirezione e la data di inizio e fine periodo di manutenzione.
        $("#global-options-form input.peer[data-title], #glb-redirect-url, #glb-maintenance-period-start, #glb-maintenance-period-end").on(eventAll, function(evt) {
            validateGlobalOption(evt);
        });

        $("#glb-under-maintenance").on("change", function(evt) {
            $("#glb-redirect-url").prop("disabled", $(this).val() != "redirect");

            validateGlobalOption(evt);
        }).triggerHandler(eventName);

        $("#glb-maintenance-banner").on("change", function(evt) {
            var dst = $("#glb-maintenance-period-start, #glb-maintenance-period-end");
            dst.prop("disabled", $(this).val() != "Y");

            validateGlobalOption(evt);
        }).triggerHandler(eventName);

        // Gestione dei button "Save" del form "global-options-form".
        $("#save-global-options").on("click", function(evt) {
            alert("save-global-options");
        });

        pageLoadCallbacks["load-global-options-page"] = function() {
            $("form#global-options-form input.peer[data-datetimepicker]").each(function() {
                var inp = $(this);

                // Evita che l'assegnazione del focus apra il popup del datetime.
                inp.datetimepicker("setOptions", { openOnFocus: false });
                this.focus({ preventScroll: true });
                inp.datetimepicker("setOptions", { openOnFocus: true });
                this.blur();
            });
        };


        //////////////////////////////////////////////////////////////////////////////////
        // Logs block.

        var refreshLogsList = function() {
            $("#logs-errors").addClass("hidden").html("");

            // Form-Data di invio.
            var formData = new window.FormData($("form#logs-form").get(0));

            $.ajax({
                type: "post",
                url: "/admin.logs.index",
                dataType: "json",
                data: formData,      // Il token csrf è già incluso nel formData.
                processData: false,  // tell jQuery not to process the data.
                contentType: false,  // tell jQuery not to set contentType.
                success: function(data, textStatus, jqXHR) {
                },
                error: function(jqXHR, textStatus, errorThrown) { ajaxError(jqXHR, "#logs-errors"); }
            });
        };

        // -
        $("form#logs-form select").on("change", function(evt) {
            refreshLogsList();
        });

        pageLoadCallbacks["load-logs-page"] = function() {
            refreshLogsList();
        };

    });
})(jQuery);
