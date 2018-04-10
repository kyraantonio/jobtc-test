/*
 * Socket.io js Server 
 * For Auto Update of containers
 * For Chat Box
 * For Browser to Browser Calling/Video Calling
 * For Interview Recording
 **/


var isUseHTTPs = !(!!process.env.PORT || !!process.env.IP);
var exec = require('child_process').exec;
var sys = require('sys');
var ws = require('ws');
var fs = require('fs');
var url = require('url');
var path = require('path');
var express = require('express');
var app = express();
var uuid = require('node-uuid');
var io = require('socket.io');

var options = {
    //Production
    key: fs.readFileSync("/etc/letsencrypt/live/job.tc/privkey.pem"),
    cert: fs.readFileSync("/etc/letsencrypt/live/job.tc/fullchain.pem"),
    //key: fs.readFileSync("/etc/apache2/ssl/apache.job.tc.2.key"),
    //cert: fs.readFileSync("/etc/apache2/ssl/apache.job.tc.2.crt")
    //Local
    //key: fs.readFileSync("E://xampp-new/htdocs/laravel-pm/main-app/public/certs/apache.key"),
    //cert: fs.readFileSync("E://xampp-new/htdocs/laravel-pm/main-app/public/certs/apache.crt")
    //linux.me
    //key: fs.readFileSync("C://xampp/apache/conf/ssl.key/server.key"),
    //cert: fs.readFileSync("C://xampp/apache/conf/ssl.crt/server.crt")
};

var server = require(isUseHTTPs ? 'https' : 'http');
var concat;

app.get('/', function (req, res) {
    res.send('<h1>Real Time Server </h1>');
});

if (isUseHTTPs) {
    server = require('https').createServer(options, app);

} else {
    server = require('http').createServer(app);
}

server.listen(3000, function () {
    console.log('Listening on Port 3000');
    console.log(isUseHTTPs);
});

io = io.listen(server);


io.on('connection', function (socket) {
    console.log('client connected');
    var room_name;
    /*
     * This is for creating a socket.io room per applicant 
     **/
    socket.on('create', function (room) {
        console.log('Joining Room,' + room);
        socket.join(room);
        room_name = room;
    });

    /*
     * This is for applicant comments 
     **/
    socket.on('applicant-comment', function (msg) {
        io.to(room_name).emit('applicant-comment', msg);
    });
    /*
     * This is for task list items
     **/
    socket.on('add-task-list-item', function (msg) {
        console.log('Sent Task list');
        console.log(msg.room_name);
        console.log(msg.task_check_list_id);
        //Emit except to sender
        socket.broadcast.to(msg.room_name).emit('add-task-list-item', msg);
    });

    /*
     * This is for task comments
     **/
    socket.on('task-comment', function (msg) {
        //console.log('task-comment: '+msg);
        io.emit('task-comment', msg);
    });
    /*
     *This is for adding tasks
     **/
    socket.on('add-task', function (task) {
        io.emit('add-task', task);
    });
    /*
     * This is for Dropping tasks to a new day or time
     **/
    socket.on('calendar-drop-task', function (task) {
        console.log('calendar-drop-task: ' + JSON.stringify(task));
        io.emit('calendar-drop-task', task);
    });
    
    socket.on('start-recording',function(video){
        console.log('starting recording in room: ' + room_name);
        io.to(room_name).emit('start-recording', video);
    });
    
    socket.on('stop-recording',function(video){
        console.log('stopping recording in room: ' + room_name);
        io.to(room_name).emit('stop-recording', video);
    });
    
    socket.on('save-video', function (video) {
        console.log('Saving video for Room: ' + room_name);
        io.to(room_name).emit('save-video', video);
    });
    
    socket.on('add-video', function (video) {
        console.log('Adding video to Room: ' + room_name);
        io.to(room_name).emit('add-video', video);
    });

    socket.on('delete-video', function (video) {
        console.log('Deleting video to Room: ' + room_name);
        io.to(room_name).emit('delete-video', video);
    });

    //region Interview Area
    var remote_id;
    socket.on('set-remote-id', function (data) {
        console.log('Saving Remote ID: ' + data);
        remote_id = data;
    });
    socket.on('start-interview', function (data) {
        io.to(room_name).emit('start-interview', {
            local: data,
            remote: remote_id
        });
        console.log('Remote: ' + remote_id + ' Local: ' + data);
    });
    socket.on('stop-interview', function (data) {
        io.to(room_name).emit('stop-interview', {
            local: data,
            remote: remote_id
        });
    });
    socket.on('add-interview', function (video) {
        io.to(room_name).emit('add-interview', video);
    });
    socket.on('generate-nfo', function (data) {
        console.log('Generating NFO file for Room: ' + room_name);
        io.to(room_name).emit('generate-nfo', {
            local: data,
            remote: remote_id
        });
    });
    socket.on('is-recording',function(status) {
        console.log("Checking room recording status");
        io.to(room_name).emit('is-recording', {
            recording: status
        });
    });
    
    //endregion
});
