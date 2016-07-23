function printNumbers() {
    var i = 0;
    var num = 0;
    var primeNumbers = "";

    for(i = 1; i <= 100; i++) {
        var counter = 0;

        for(num = i; num >= 1; num--) {
            if(i%num == 0) {
                counter += 1;
            }
        }
        if( counter == 2)
        {
            primeNumbers = primeNumbers + i + " ";

        }
    }

    console.log(primeNumbers);
}