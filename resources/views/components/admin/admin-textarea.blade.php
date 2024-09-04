{{--
    Nota: in assenza dell'attributo "rows" nel "tag-alias", il valore di default è "10".

    Nota: in assenza dell'attributo "data-resize" nel "tag-alias", la classe aggiunta sarà "resize-y".
          Se nel "tag-alias" è specificato l'attributo "data-resize", la classe aggiunta sarà costituita
          dalla stringa "resize-" a cui viene concatenato il valore dell'attributo "data-resize".
--}}
@props(["rows" => "10", "data-resize" => "y"])
<textarea rows="{{ $rows }}" {!! $attributes->merge(["class" => "resize-" . ${'data-resize'} . " peer block min-h-[auto] w-full whitespace-pre rounded border-0 bg-white px-3 pb-[0.32rem] leading-tight outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"]) !!}>{!! $slot !!}</textarea>
