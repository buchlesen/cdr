<footer class="app-footer">
    <div class="site-footer-right">
        @if (rand(1,100) == 100)
            <i class="voyager-rum-1"></i> Made with rum and even more rum
        @else
            Made with <i class="voyager-heart"></i> by <a href="https://malifaxsolutions.com/" target="_blank">Malifax Solutions</a>
        @endif
        @php $version = Voyager::getVersion(); @endphp
        @if (!empty($version))
            - {{ $version }}
        @endif
    </div>
</footer>
