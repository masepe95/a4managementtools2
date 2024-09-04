{{--
    Nota: in assenza dell'attributo "type" nel "tag-alias", il valore è "button".
          Specificare un altro valore di "type" se il tipo non deve essere "button" (esempio: submit o reset).

    Nota: il colore di default del ripple (se data-te-ripple-color non viene specificato
          nel "tag alias") è "light".
          Per impostare un altro colore, specificare l'attributo data-te-ripple-color="dark"
          nel "tag alias".
--}}
@props(["type" => "button", "data-te-ripple-color" => "light"])
<button type="{{ $type }}" data-te-ripple-init="" data-te-ripple-color="{{ ${'data-te-ripple-color'} }}"
        {!! $attributes->merge(["class" => $attributes->has("data-te-dropdown-toggle-ref")
            ? "disabled:pointer-events-none disabled:opacity-60 relative flex items-center whitespace-nowrap rounded w-full a4-bg-shade-100 px-3 pt-2.5 pb-2 text-base font-normal tracking-wider leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-500 ease-in-out hover:bg-primary-800 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-800 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-900 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] motion-reduce:transition-none dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
            : "disabled:pointer-events-none disabled:opacity-60 relative inline-block rounded a4-bg-shade-100 px-6 pt-2.5 pb-2 text-xs font-medium uppercase tracking-widest leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-500 ease-in-out hover:bg-primary-800 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-800 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-900 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"]) !!}>
    {!! $slot !!}
</button>
