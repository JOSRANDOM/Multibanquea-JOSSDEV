<script>
    window.addEventListener('load', function() {
    // Code to be executed when all page resources have finished loading
    var expiration_time = "{{ session()->get('exam_expiration_time') }}";
    var countDownDate = new Date(expiration_time.replace(/\s/, 'T')).getTime();

    if(expiration_time.trim()!='') {
        // Update the count down every 1 second
        var x = setInterval(function () {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            document.getElementById("countdown_exam").innerHTML = pad(hours) + ":" + pad(minutes) + ":" + pad(seconds);
            if(distance < 180000 ){
                document.getElementById("countdown_exam").classList.add("blink");
                document.getElementById("countdown_icon").classList.add("blink");
            }

            // If the count down is over, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown_exam").innerHTML = "00:00:00";

                $.ajax({
                    type: 'GET',
                    url: "{{ route('exams.finish.exam', $exam)  }}",
                    success: function (data) {
                        location.href = '{{  route('exams.show', $exam)  }} ';
                    }
                });

            }
        }, 1000);
    }
    function pad(n) {
        return (n < 10 ? "0" + n : n);
    }
});

</script>
