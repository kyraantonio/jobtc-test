var casper = require('casper').create({
    verbose: true,
    logLevel: 'debug',
    pageSettings: {
        loadImages: false, // The WebPage instance used by Casper will
        loadPlugins: false, // use these settings
        webSecurityEnabled: false,
        ignoreSslErrors: true,
        viewportSize: {width: 1366, height: 784}
        //userAgent: "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.131 Safari/537.36"
    }
//remoteScripts: ['https://code.jquery.com/jquery-2.1.4.min.js']
});

casper.start(casper.cli.get('url') + '/login', function () {
    this.fill('form#login-form', {
        'email': casper.cli.raw.get('jobtc_email'),
        'password': casper.cli.raw.get('jobtc_password')
    }, true);
});

casper.thenOpen(casper.cli.get('url') + '/applyToJobForm', function () {
    var token = this.getElementAttribute('input[type="hidden"][name="_token"]', 'value');
    var candidateData = {
        name: 'Test User',
        email: 'testuser@test.com',
        phone: '12345677890',
        job: 'General',
        _token: token
    };

    this.echo("Response: " + JSON.stringify(candidateData), 'INFO');
    ajaxrequest = this.evaluate(function (data, url) {
        return __utils__.sendAJAX(url + '/addApplicantFromCrawler', 'POST', data, false);
        
    }, candidateData, casper.cli.get('url'));
});

casper.then(function() {
    //require('utils').dump(ajaxrequest);
});

casper.run();
