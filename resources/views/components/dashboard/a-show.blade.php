<x-dashboard.base.a {{ $attributes->class([])->merge(['href' => '#']) }} class="btn btn-sm btn-icon btn-success">
    <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z"
            stroke="currentColor"></path>
        <circle cx="12" cy="12" r="5" stroke="currentColor"></circle>
        <circle cx="12" cy="12" r="3" fill="currentColor"></circle>
        <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6" height="6">
            <circle cx="12" cy="12" r="3" fill="currentColor"></circle>
        </mask>
        <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white"></circle>
    </svg>
</x-dashboard.base.a>