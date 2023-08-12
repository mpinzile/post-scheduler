const express = require('express');
const app = express();
const bodyParser = require('body-parser');
const cors = require('cors')
const UserRegistration = require('./modules/register');
const UserLogin = require('./modules/login');
const AddPost = require('./modules/addPost');
const GetPost = require('./modules/getPost');
const PORT = 8000;

app.use(bodyParser.json());
app.use(cors());

app.post('/register',UserRegistration);
app.post('/login',UserLogin);
app.post('/addPost',AddPost);
app.get('/getPost',GetPost);
app.listen(PORT,()=>{
    console.log(`server is listening on port ${PORT}`);
})