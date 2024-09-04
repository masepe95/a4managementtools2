{{--
    Nota: se disabilitato, il background sarà 'bg-neutral-100' anziché 'bg-white'.
          Vedi classe 'disabled:bg-neutral-100' e 'enabled:bg-white'.
          Inoltre, se disabilitato, il colore del testo è 'disabled:text-neutral-400'.
          L'attributo 'type' deve essere specificato nel "tag alias" (text, email, password, tel ....).
--}}
<input {!! $attributes->merge(["class" => "peer block min-h-[auto] w-full rounded border-0 disabled:bg-neutral-100 disabled:text-neutral-400 enabled:bg-white py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-300 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"]) !!} />
