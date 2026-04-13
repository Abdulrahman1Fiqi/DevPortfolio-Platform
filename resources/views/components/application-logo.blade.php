<svg {{ $attributes }} viewBox="0 0 200 40" fill="none"
     xmlns="http://www.w3.org/2000/svg">

    {{-- Code bracket icon --}}
    <g>
        {{-- Left bracket < --}}
        <path d="M12 8 L4 20 L12 32"
              stroke="#6366f1" stroke-width="3"
              stroke-linecap="round" stroke-linejoin="round"/>

        {{-- Right bracket > --}}
        <path d="M22 8 L30 20 L22 32"
              stroke="#6366f1" stroke-width="3"
              stroke-linecap="round" stroke-linejoin="round"/>

        {{-- Slash / in the middle --}}
        <path d="M18 6 L16 34"
              stroke="#a5b4fc" stroke-width="2.5"
              stroke-linecap="round"/>
    </g>

    {{-- DevPortfolio text --}}
    <text x="38" y="26"
          font-family="ui-sans-serif, system-ui, sans-serif"
          font-size="16"
          font-weight="700"
          fill="#1e1b4b">Dev</text>

    <text x="72" y="26"
          font-family="ui-sans-serif, system-ui, sans-serif"
          font-size="16"
          font-weight="400"
          fill="#6366f1">Portfolio</text>

</svg>