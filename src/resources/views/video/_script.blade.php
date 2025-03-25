<script>
    document.addEventListener('alpine:init', function () {
        Alpine.data('videoModal{{ $modalId }}', () => ({
            driver: @json(old('driver', $video?->driver)),
            get referenceLabel() {
                let driver = this.$store.vaniloVideoDrivers.drivers[this.driver]

                return driver ? driver.referenceIs : '{{ __('Reference') }}'
            }
        }))
    })
</script>

@pushonce('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('vaniloVideoDrivers', {
                drivers: {
                    @foreach(vnl_video_drivers() as $id => $driver)
                        "{{ $id }}": @json($driver),
                    @endforeach
                }
            })
        })
    </script>
@endpushonce
