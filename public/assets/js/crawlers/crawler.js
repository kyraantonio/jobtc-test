/*
 * Indeed Crawler 
 * Author: Jexter Dean Buenaventura
 **/

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
casper.echo(casper.cli.get('insert'));
casper.echo(casper.cli.get('applicants_dir'));

var url = 'https://employers.indeed.com/m#jobs';
var linkurl = 'https://employers.indeed.com/m';
var candidateurl = 'https://employers.indeed.com/m#candidates?id=0';
var downloadurl = 'https://employers.indeed.com';
var candidatesPageArray;
var links = [];
var candidates = [];
var found = [];
var nextLink;
//For Job
var title;
var desc;
//For Candidate
var name_str;
var name;
var first_name;
var last_name;
var email;
var email_phone_str;
var email_phone;
var phone;
var job_title_str;
var job_title;
var job;
var resume;
//For Http Validation
var token;
//For Directory

casper.start(url, function () {
    this.fill('form#loginform', {
        email: 'projectmanager@hdenergy.ca',
        password: '1234567890'
    }, true);
});
casper.then(function () {
    //Check if the job table has been loaded
    if (this.exists('td.job')) {
        this.echo(this.getTitle());
    } else {
        this.echo('element does not exist');
    }
});
casper.then(function () {
    this.echo(this.getTitle());
    //this.click('.rwC');
});
casper.then(function () {
    this.click('.rwC');
    this.wait(3000, function () {
        //this.clickLabel('Construction Worker', 'a');
        links = this.evaluate(getJobLinks);
        this.each(links, function (self, link) {
            self.thenOpen(linkurl + link, function () {
                self.wait(3000, function () {
                    self.echo(self.getCurrentUrl());
                    //this.test.assertExists('div#jD', 'Job Description Exists');
                    //this.echo(this.fetchText('div#jD'));
                    self.echo('Starting Ajax request');
                    title = self.getTitle();
                    desc = self.fetchText('div#jD');
                    self.echo(title, 'INFO');
                    self.echo(desc, 'INFO');
                    /*TODO:: Fix ajax transaction*/
                    casper.thenOpen(casper.cli.get('insert')+'/dashboard', function () {
                        this.wait(3000, function () {
                            this.fill('form#login-form', {
                                email: 'projectmanager@hdenergy.ca',
                                password: '12345'
                            }, true);
                        });
                    });
                    casper.thenOpen(casper.cli.get('insert')+'/add-job-form', function () {
                        var token = this.getElementAttribute('input[type="hidden"][name="_token"]', 'value');
                        var jobData = {
                            title: title,
                            description: desc,
                            photo: '',
                            _token: token,
                            id: 4
                        };
                        //this.fill('form.add-job-form', jobData, true);
                        this.evaluate(function (data,url) {
                            __utils__.sendAJAX(url+'/add-job-crawler', 'POST', data, false);
                        }, jobData,casper.cli.get('insert'));
                    });
                });
            });
        });
    });
});
casper.thenOpen(candidateurl, function () {
    this.wait(3000, function () {
        temp = this.evaluate(getPaginationLinks);
        //temp.push(candidateurl);
        candidatesPageArray = temp.reduce(function (a, b) {
            if (a.indexOf(b) < 0)
                a.push(b);
            return a;
        }, []);
    });
});

casper.then(function () {
    this.wait(3000, function () {
        candidatesPageArray.push(candidateurl);
    });
});
casper.then(function () {
    //candidatesPageArray.push(candidateurl);
    this.each(candidatesPageArray, function (self, link) {
        self.thenOpen(link, function () {
            self.wait(3000, function () {
                found = this.evaluate(getCandidateLinks);
                candidates = candidates.concat(found);
            });
        });
    });
});
casper.then(function () {
    candidates = candidates.reduce(function (a, b) {
        if (a.indexOf(b) < 0)
            a.push(b);
        return a;
    }, []);
});

casper.thenOpen(casper.cli.get('insert')+'/dashboard', function () {
    this.wait(3000, function () {
        this.fill('form#login-form', {
            email: 'projectmanager@hdenergy.ca',
            password: '12345'
        }, true);
    });
});
casper.thenOpen(casper.cli.get('insert')+'/apply-to-job-form', function () {
    token = this.getElementAttribute('input[type="hidden"][name="_token"]', 'value');
});
casper.then(function () {
    //candidates = candidates.toString();
    //candidatesArray = candidates.split(",");
    //this.echo(candidates);
    this.each(candidates, function (self, link) {
        self.thenOpen(linkurl + link, function () {
            self.then(function () {
                self.wait(10000, function () {
                    //self.echo(self.fetchText('h3.name'), 'INFOit(",");
                    //this.echo(candidates);');
                    self.echo(self.fetchText('a[data-element=back-job]'), 'INFO');
                    self.echo(self.fetchText('div.name-plate p'), 'INFO');
                    self.echo(this.getElementAttribute('a[data-element=download-resume]', 'href'), 'INFO');
                    //Split the name to first name and last name
                    var name_str = self.fetchText('h3.name');
                    var name = name_str.split(" ");
                    if (name.length > 3) {

                        this.echo("Name length: " + name.length);

                        first_name = name[0] + " " + name[1];
                        last_name = name[2];
                    } else {
                        
                        this.echo("Name length: " + name.length);
                        first_name = name[0];
                        last_name = name[1];
                    }
                    self.echo("First Name: " + first_name);
                    self.echo("Last Name: " + last_name);
                    //Split the email and phone
                    var email_phone_str = self.fetchText('div.name-plate p');
                    var email_phone = email_phone_str.split("|");
                    email = email_phone[0];
                    phone = email_phone[1];
                    //self.echo("Email: " + email);
                    //self.echo("Phone: " + phone);
                    //Get Job Title
                    var job_title_str = self.fetchText('a[data-element=back-job] span');
                    var job_title = job_title_str.split(' ');
                    job = job_title[2];
                    self.echo("Job Title: " + job, 'INFO');
                    resume = downloadurl + "" + this.getElementAttribute('a[data-element=download-resume]', 'href');
                    //self.echo(resume);
                    //resume.push(resumeurl);

                    casper.download(resume, 'Resume' + first_name + last_name + '.pdf');
                    var candidateData = {
                        first_name: first_name,
                        last_name: last_name,
                        email: email,
                        phone: phone,
                        job: job,
                        resume: '',
                        _token: token,
                        
                    };
                    self.evaluate(function (data,url) {
                        __utils__.sendAJAX(url+'/add-applicant', 'POST', data, false);
                    }, candidateData,casper.cli.get('insert'));
                    //self.echo("Response: " + data, 'INFO');
                   
                });
            });
        });
    });
});

casper.then(function () {
    this.echo('__END__');
    this.exit();
});

casper.on('resource.received', function (resource) {
    "use strict";

    this.echo(resource.url);
    var url, file;
    url = resource.url;
    //file = "stats.csv";
    try {
        //this.echo("Attempting to download file " + file);
        //var fs = require('fs');
        var fs = require('fs');
        //fs.changeWorkingDirectory('E:/xampp-new/htdocs/hirefitnet/hirefitnet/public/uploads/applicants');
        fs.changeWorkingDirectory(casper.cli.raw.get('applicants_dir'));
        //this.echo(fs.workingDirectory);
        //casper.download(resource.url, fs.workingDirectory+'/'+file);
    } catch (e) {
        this.echo(e);
    }

});

casper.on('step.error', function(err) {
    this.die("Step has failed: " + err);
});


casper.run();



/* Functions */
function sendApplicantData(data,url) {
    this.evaluate(function (data,url) {
        return __utils__.sendAJAX(casper.cli.get('insert')+'/add-applicant', 'POST', data, false);
    }, data, url);
}
function getJobs() {
    this.echo(this.getTitle());
    this.test.assertExists('div#jD', 'Job Description Exists');
    this.echo('Starting Ajax request');
    var title = this.getTitle();
    var desc = this.fetchText('div#jD');
    /*TODO:: Fix ajax transaction*/
    casper.thenOpen(casper.cli.get('insert')+'/dashboard', function () {
        this.wait(3000, function () {
            this.fill('form#login-form', {
                email: 'projectmanager@hdenergy.ca',
                password: '12345'
            }, true);
        });
    });
    casper.thenOpen(casper.cli.get('insert')+'/add-job-form', function () {
        var token = this.getElementAttribute('input[type="hidden"][name="_token"]', 'value');
        var jobData = {
            title: title,
            description: desc,
            photo: '',
            _token: token,
            id: 4
        };
        //this.fill('form.add-job-form', jobData, true);
        this.evaluate(function (data) {
            __utils__.sendAJAX(casper.cli.get('insert')+'/add-job-crawler', 'POST', data, false);
        }, jobData);
    });
}

function addCandidateLinks(link) {
    this.then(function () {
        var found = this.evaluate(getCandidateLinks);
        this.echo(found.length + " links found on " + link);
        candidates = candidates.concat(found);
    });
}

function getJobLinks() {
    var links = document.querySelectorAll('.jobTitle');
    return Array.prototype.map.call(links, function (e) {
        return e.getAttribute('href');
    });
}

function getCandidateLinks() {
    var links = document.querySelectorAll('.candidate-link');
    return Array.prototype.map.call(links, function (e) {
        return e.getAttribute('href');
    });
}

function traversePages() {
    nextLink = ".pagination > a[data-element=page-next]";
    if (casper.visible(nextLink)) {
//casper.thenOpen(candidateurl);
        this.test.assertExists(nextLink);
        this.click(nextLink);
        this.wait(3000, function () {

            casper.then(getCandidates);
        });
    } else {
//this.echo("__END__");
//casper.echo("number of candidates: " + candidates.length);
        this.echo(candidatePageArray);
    }
}

function getCandidatesArray(page) {
    casper.open(page, function () {
        candidates = this.evaluate(getCandidateLinks);
        this.each(candidates, function (self, link) {
            self.thenOpen(linkurl + link, function () {
                self.wait(3000, function () {
//self.echo(self.getCurrentUrl());
                    self.echo(self.fetchText('h3.name'));
                    self.echo(self.fetchText('ul#appliedJobsList li'));
                    self.echo(self.fetchText('div.name-plate p'));
                    //Split the name to first name and last name
                    var name_str = self.fetchText('h3.name');
                    var name = name_str.split(" ");
                    first_name = name[0];
                    last_name = name[1];
                    self.echo("First Name: " + first_name);
                    self.echo("Last Name: " + last_name);
                    //Split the email and phone
                    var email_phone_str = self.fetchText('div.name-plate p');
                    var email_phone = email_phone_str.split("|");
                    email = email_phone[0];
                    phone = email_phone[1];
                    self.echo("Email: " + email);
                    self.echo("Phone: " + phone);
                    //Get Job Title
                    var job_title_str = self.fetchText('ul#appliedJobsList li');
                    var job_title = job_title_str.split('-');
                    job = job_title[0];
                    self.echo("Job Title: " + job);
                    var candidateData = {
                        first_name: first_name,
                        last_name: last_name,
                        email: email,
                        phone: phone,
                        job: job,
                        resume: '',
                        _token: token
                    };
                    //this.fill('form.add-job-form', jobData, true);

                    casper.thenOpen(casper.cli.get('insert')+'/dashboard', function () {
                        this.wait(3000, function () {
                            this.fill('form#login-form', {
                                email: 'projectmanager@hdenergy.ca',
                                password: '12345'
                            }, true);
                        });
                        this.evaluate(function (data) {
                            __utils__.sendAJAX(casper.cli.get('insert')+'/add-applicant', 'POST', data, false);
                        }, candidateData);
                    });
                });
                //self.test.assertExists('a[data-element="download-resume"]');
            });
        });
    });
    return true;
}

function getPaginationLinks() {
    var links = document.querySelectorAll('.pagination a');
    return Array.prototype.map.call(links, function (e) {
        return e.getAttribute('href');
    });
}
