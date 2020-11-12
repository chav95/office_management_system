function test(n){
    var a = [0,1]
    if (n <= 2) return 1
    for (var i = 2; i <=n; i++){
        a[i] = a[i-1]+a[i-2];
    }
    return a[n]
}