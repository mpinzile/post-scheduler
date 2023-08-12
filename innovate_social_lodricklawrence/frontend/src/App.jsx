import {BrowserRouter as Router, Route,Routes } from 'react-router-dom';
import Register from './pages/register';
import Login from './pages/login';
import AddPost from './pages/addPost';
import Posts from './pages/posts';
function App() {

  return (
    <Router>
      <Routes>
        <Route path='/' element={<Login />}></Route>
        <Route path='/register' element={<Register />}></Route>
        <Route path='/addPost/:email' element={<AddPost />}></Route>
        <Route path='/posts' element={<Posts />}></Route>
        <Route></Route>
        <Route></Route>
      </Routes>
    </Router>
  )
}

export default App
