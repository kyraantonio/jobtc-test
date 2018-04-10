@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid box-default">
                <div class="box-header">
                    <h3 class="box-title">Documentation</h3>
                </div>
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-3">
                            <ul class="ver-inline-menu tabbable margin-bottom-10">
                                <li class="active">
                                    <a data-toggle="tab" href="#tab_1">
                                        <i class="fa fa-check"></i> What is freelance plus? </a>
									<span class="after">
									</span>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab_2">
                                        <i class="fa fa-check"></i> Pre requisite </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab_3">
                                        <i class="fa fa-check"></i> How to install </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab_4">
                                        <i class="fa fa-check"></i> Modules </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab_6">
                                        <i class="fa fa-check"></i> Permission </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab_5">
                                        <i class="fa fa-check"></i> FAQ </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content">
                                <div id="tab_1" class="tab-pane active">
                                    <div id="accordion1" class="panel-group">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion1" href="#accordion1_1">
                                                        1. About Application</a>
                                                </h4>
                                            </div>
                                            <div id="accordion1_1" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    Freelance Plus is a web based project management application and can
                                                    be used by any type of freelancers who wish to manage their works.
                                                    Its a lightweight application and designed to provide an easy
                                                    application for freelancers. <br/><br/>

                                                    It is designed in laravel 4 framework with MVC structure.

                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion1" href="#accordion1_2">
                                                        2. Support</a>
                                                </h4>
                                            </div>
                                            <div id="accordion1_2" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <strong>Supports only available to my customers who have bought this
                                                        application from envato only.</strong> <br/><br/>

                                                    You can either comment on the comment section of this application or
                                                    go to support section and fill out the form.
                                                    Support available from 5pm (IST) to 11pm(IST). You can also mail me
                                                    at webmaster.vinay@gmail.com
                                                    Dont forget to mention your purchase code if you are asking for
                                                    support first time. Purchase code is available
                                                    in the download section of every application.<br/><br/>

                                                    <strong>If you like my apps then do rate it on code canyon.
                                                        :)</strong> <br/><br/>

                                                    Your suggestions are always welcome and I will definetly try to
                                                    implete your suggestions in next releases.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_2" class="tab-pane">
                                    <div id="accordion2" class="panel-group">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion2" href="#accordion2_1">
                                                        1. Application requirements </a>
                                                </h4>
                                            </div>
                                            <div id="accordion2_1" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <p>
                                                        It is designed in laravel 4 framework with MVC structure.
                                                        Everything that requires to be installed for laravel is required
                                                        by this application. <br/><br/>

                                                        The Laravel framework has a few system requirements:

                                                    <ul>
                                                        <li>PHP >= 5.4</li>
                                                        <li>MCrypt PHP Extension</li>
                                                    </ul>

                                                    This application also uses following packages as supplymentry.
                                                    Requirement by these supplements will also be required by this
                                                    application:

                                                    <ul>
                                                        <li>Zizaco/Entrust</li>
                                                        <li>Cviebrock/image-validator</li>
                                                        <li>intervention/image</li>
                                                    </ul>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_3" class="tab-pane">
                                    <div id="accordion3" class="panel-group">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion3" href="#accordion3_1">
                                                        1. Installation note </a>
                                                </h4>
                                            </div>
                                            <div id="accordion3_1" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <ul>
                                                        <li>Download the latest version available on codecanyon.</li>
                                                        <li>Extract it on your server.</li>
                                                        <li>Open
                                                            <your-project-location>/install with your browser.
                                                        </li>
                                                        <li>Enter details in the input fields. Make sure these
                                                            information are correct. You must create a database with the
                                                            same name which you have provided here.
                                                        </li>
                                                        <li>Click on 'Install App' button and wait for completion. This
                                                            might take few minutes depending on your server
                                                            configuration.
                                                        </li>
                                                        <li>After completion if you receive primary message then you
                                                            have primaryfully install this application & you can now log
                                                            in!!
                                                        </li>
                                                    </ul>

                                                    If you want to install it in your local system then you can create a
                                                    virtual host. A nice tutorial on how to create a virtual host can be
                                                    found <a
                                                            href="http://www.techrepublic.com/blog/smb-technologist/create-virtual-hosts-in-a-wamp-server/"
                                                            target=_blank>here</a>. <br/><br/>
                                                    If you want to install it in any subfolder of your webserver then
                                                    you have to configure few files. A nice tutorial on how to setup
                                                    laravel application on subfolder can be found <a
                                                            href="http://stackoverflow.com/questions/16683046/how-to-install-laravel-4-to-a-web-host-subfolder-without-publicly-exposing-app"
                                                            target=_blank>here</a> <br/><br/>
                                                    You can also install it manually by following these stpes: <br/>
                                                    <ul>
                                                        <li>Download the latest version available on codecanyon.</li>
                                                        <li>Extract it on your server.</li>
                                                        <li>Create a new database.</li>
                                                        <li>Open app/config/database.php</li>
                                                        <li>Set hostname, username, password, database name</li>
                                                        <li>Import the SQL file located in app/database folder.</li>
                                                        <li>Now you can open your project with any browser by navigating
                                                            to
                                                            <your-project-location>
                                                        </li>
                                                    </ul>
                                                    If you found difficulty in installing the application then you can
                                                    mail me at webmaster.vinay@gmail.com
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_4" class="tab-pane">
                                    <div id="accordion4" class="panel-group">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion4" href="#accordion4_1">
                                                        1. Client </a>
                                                </h4>
                                            </div>
                                            <div id="accordion4_1" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    In this module, you can add your customer with all the given
                                                    options. You can edit the customer info
                                                    at any time. Only 'Admin' can access this module. Any number of
                                                    users can be created by the 'Admin'
                                                    for any client and then client can log-in to this application & can
                                                    check the invoices/estimates/projects.
                                                    After log-in client can also raise ticket. Private message is also
                                                    available for client.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion4" href="#accordion4_2">
                                                        2. Estimate </a>
                                                </h4>
                                            </div>
                                            <div id="accordion4_2" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    This module is also available only to the 'Admin' & 'Client'.
                                                    Estimates can be created and sent by mail to the client's email id.
                                                    Once confirmed an estimate can be converted into invoice. Client can
                                                    login and check only his estimates.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion4" href="#accordion4_3">
                                                        3. Invoice </a>
                                                </h4>
                                            </div>
                                            <div id="accordion4_3" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    This module is also available only to the 'Admin' & 'Client'. An
                                                    invoice can be raised againts customer order and can be
                                                    sent to the client's email id. Client can only check the invoice
                                                    whereas 'Admin' can edit/delete the invoice as well as
                                                    can make payment to this invoice.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion4" href="#accordion4_4">
                                                        4. Projects </a>
                                                </h4>
                                            </div>
                                            <div id="accordion4_4" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    Projects are the work orders given the the company. Any number of
                                                    projects can be added by the 'Admin'. This module is also available
                                                    to
                                                    the 'Staff' only if 'Admin' has assigned that project to the
                                                    'Staff'. Private notes can be maintained by the project worker.
                                                    Comments & attachments
                                                    are also available to make their work easy. A project timer is
                                                    available to manage by the 'Admin'. 'Admin' can also create task for
                                                    any projects.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion4" href="#accordion4_5">
                                                        5. Bug Tracking </a>
                                                </h4>
                                            </div>
                                            <div id="accordion4_5" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    Bug trackig can be managed in this module. It is avalaible to
                                                    'Admin' & 'Staff'. All the things available in projects are also
                                                    available in this module.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion4" href="#accordion4_6">
                                                        6. Ticket </a>
                                                </h4>
                                            </div>
                                            <div id="accordion4_6" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    Any 'Staff' or 'Client' can raise a ticket for any issue. Once the
                                                    issue is resolved ticket status can be changed to 'close' by 'Staff'
                                                    or 'Admin'.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion4" href="#accordion4_7">
                                                        7. Message </a>
                                                </h4>
                                            </div>
                                            <div id="accordion4_7" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    These are private messages that can be sent to any user registered
                                                    on the application. Inbox and outbox both are managed in the
                                                    application.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion4" href="#accordion4_8">
                                                        8. Setting </a>
                                                </h4>
                                            </div>
                                            <div id="accordion4_8" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    These are general setting which can only be accessible by 'Admin'.
                                                    It includes various fields like image type allowed to upload, max
                                                    image size, default tax, discount, currency, timezone etc.
                                                    Email templates can also be managed under this section.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_6" class="tab-pane">
                                    <div id="accordion6" class="panel-group">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion6" href="#accordion6_1">
                                                        1. Admin access</a>
                                                </h4>
                                            </div>
                                            <div id="accordion6_1" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <p>
                                                        An admin can access complete application. He can also manages
                                                        other users. He can access Setting page where he/she can change
                                                        default values. No staff/client should access this page.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion6" href="#accordion6_2">
                                                        2. Employee/Staff access</a>
                                                </h4>
                                            </div>
                                            <div id="accordion6_2" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <p>
                                                        A staff can only manage Projects/Bugs/Tickets module if Admin
                                                        has assigned it to him. Admin can specifically assign a user
                                                        access to few projects. He can send/receive private messages.
                                                        Can raise a ticket. Can change his/her profile.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion6" href="#accordion6_3">
                                                        3. Client access</a>
                                                </h4>
                                            </div>
                                            <div id="accordion6_3" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <p>
                                                        A client can access his project/bugs or tickets that he has
                                                        raised. He can also use private messanging.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_5" class="tab-pane">
                                    <div id="accordion5" class="panel-group">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion5" href="#accordion2_1">
                                                        1. Can I use this application on my local computer system? </a>
                                                </h4>
                                            </div>
                                            <div id="accordion5_1" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <p>
                                                        Yes, you can use it in your local system with local server
                                                        installed in your system. You must have Apache/MYSQL/PHP support
                                                        on your server. You can also use this application on local
                                                        network.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion5" href="#accordion5_2">
                                                        2. How can I add more langauges for tanslation?</a>
                                                </h4>
                                            </div>
                                            <div id="accordion5_2" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <p>
                                                    <ul>
                                                        <li>Open app/views/setting/index.blade.php . Add a langauge of
                                                            your choice in the select field.
                                                        </li>
                                                        <li>Now create a folder and rename it to given language name.
                                                            For example for 'french' language, a folder is created with
                                                            name 'fr'.
                                                        </li>
                                                        <li>Create a file message.php and return an array with all the
                                                            possible word translation in that file.
                                                        </li>
                                                        <li>Now go to setting and select that language as default
                                                            language.
                                                        </li>
                                                        <li>That's it. You have primaryfully changed tha language.</li>
                                                    </ul>

                                                    You can also add phrases to translate. You need to add that phrase
                                                    with translation in corresponding message.php file & then replace
                                                    that word with {{ Lang::get('messages.your_word') }} . It will
                                                    replace "your_word" with translation you have added in message.php
                                                    file.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion5" href="#accordion5_3">
                                                        2. How can I send mail using SMTP?</a>
                                                </h4>
                                            </div>
                                            <div id="accordion5_3" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <p>
                                                    <ul>
                                                        <li>Open app/config/mail.php.</li>
                                                        <li>Change the "driver" to smtp & set
                                                            host,from,username,password,port values.
                                                        </li>
                                                        <li>You are now ready to send mail via SMTP!!</li>
                                                    </ul>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop