import { useState } from "react";
import { useParams ,Link } from "react-router-dom"

function AddPost() {
    const {email} = useParams();
    const [title,setTitle] = useState('');
    const [content,setContent] = useState('');
    const [retrievedAt,setRetrievedAt] = useState('')
    
    const handleTitleChange = (event) => {
        setTitle(event.target.value)
    }

    const handleContentChange = (event) => {
        setContent(event.target.value)
    }

    const handleRetrievedAtChange = (event) => {
        setRetrievedAt(event.target.value)
    }

    const handleSubmit = async (event) => {
        event.preventDefault();
        try {
            const response = await fetch('http://localhost:8000/addPost',{
                method:'POST',
                headers:{
                    'Content-Type': 'application/json'
                },
                body:JSON.stringify({
                    email : email,
                    title : title,
                    content : content,
                    retrievedAt : retrievedAt
                })
            })

            if(response.ok){
                const data = await response.json();
                alert(data.message);
            }else{
                console.log("request failed status",response.status)
            }

        } catch (error) {
            console.log(error)
        }

    }
  return (
    <div>
    <Link to='/posts'>View All Posts</Link>    
    <form onSubmit={handleSubmit}>
        <label>Post Title</label>
        <input type="text" value={title} onChange={handleTitleChange} />
        <br /> <br />
        <label>Post Content</label>
        <textarea cols="30" rows="10" value={content} onChange={handleContentChange} />
        <br /> <br/>
        <label>Retrieved At</label>
        <input type="time" value={retrievedAt}  onChange={handleRetrievedAtChange} />
        <br /> <br/>
        <input type="submit" value="ADD-POST" />
    </form>
</div>
  )
}

export default AddPost