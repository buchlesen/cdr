<footer class="app-footer">
    <div class="site-footer-right">
        @if (rand(1,100) == 100)
            <i class="voyager-rum-1"></i> Made with rum and even more rum
        @else
            Made with <i class="voyager-heart"></i> by <a href="https://www.malifax.com.sg/" target="_blank">Malifax Technologies</a>
        @endif
        @php $version = Voyager::getVersion(); @endphp
        @if (!empty($version))
            - {{ $version }}
        @endif
    </div>
</footer>
