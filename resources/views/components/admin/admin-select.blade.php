{{--
    L'attributo "data-te-select-init" è definito qui.
    Gli attributi "data-te-select-no-result-text" e "data-te-select-search-placeholder" sono sempre
    specificati indipendentemente che il filtro venga abilitato oppure no.
    Il valore di threshold di default, per attivare il filtro di ricerca, è 25 se non specificato
    diversamente nel 'tag alias' tramite l'attributo "data-search-threshold".
    Se il valore della property "data-option-count" supera quello del threshold, il filtro di ricerca
    viene attivato già durante l'inizializzazione (data-te-select-filter="true").
    Il filtro può essere abilitato/disabilitato dinamicamente tramite JavaScript impostando le
    properties:
      $("#select").attr("data-te-select-filter", "true"|"false")  // string.

      var teSel = te.Select.getInstance(sel);
      teSel._config.selectFilter = true|false;                    // boolean.

    Eventualmente, impostare anche:
      $("#select").data("te-select-filter", true|false)  // boolean.
      teSel._classes.teSelectFilter = "true"|"false";    // string.

    Nota: gli attributi listati nel blocco @props() non vengono inclusi nel tag finale, l'attributo
          "multiple" è necessario ed è quindi incluso esplicitamente (vedi condizione $multiple !== false).
          Anche l'attributo "data-search-threshold" viene incluso nel tag finale con il valore di
          default o quello esplicito nel 'tag alias'.

    Nota: l'attributo "data-option-count" non viene mai incluso nel tag finale, il suo valore (di default
          o esplicito nel 'tag alias') serve ad inizializzare l'attributo "data-te-select-filter=true".
          Se non specificato nel 'tag alias', il valore 0 di default di "data-option-count" non attiva
          mai l'attributo "data-te-select-filter=true", questo può in seguito essere gestito dinamicamente
          come indicato sopra.

    Nota: il valore dell'attributo data-te-select-visible-options (default = 10) determina il numero di
          <option> presenti nel <select>.
          Nel conteggio del numero visibile viene tenuto conto anche di eventuali <optgroup>.
--}}
@props(["multiple" => false, "data-search-threshold" => 25, "data-option-count" => 0])
<select {!! $attributes->merge() !!} data-te-select-init="" data-te-select-no-result-text="{{ __('globals.select-noresult-filter') }}" data-te-select-search-placeholder="{{ __('globals.select-search-filter-text') }}"{!! (${'data-option-count'} > ${'data-search-threshold'}) ? ' data-te-select-filter="true"' : '' !!} data-search-threshold="{{ ${'data-search-threshold'} }}"{!! ($multiple !== false) ? ' data-te-select-all-label="' . __('globals.select-select-all') . '" multiple' : '' !!}>
    {{ $slot }}
</select>
