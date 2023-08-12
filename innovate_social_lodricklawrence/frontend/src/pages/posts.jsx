import { useEffect,useState } from "react";

function Posts() {
    const [posts,setPosts] = useState([]);
    useEffect(()=>{
        async function retrievePosts(){
            const response = await fetch('http://localhost:8000/getPost',{
                method:'GET',
            })

            const data = await response.json();
            setPosts(data);
        }

        retrievePosts()
    },[])

  return (
    <div>
        {posts.map(post => (
            <table key={post.id} border={1} style={{borderCollapse: 'collapse'}}>
                <thead>
                    <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>CreatedDate</th>
                    <th>CreatedTime</th>
                    <th>RetrievedTime</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>{post.title}</td>
                    <td>{post.content}</td>
                    <td>{post.date}</td>
                    <td>{post.createdAt}</td>
                    <td>{post.retrievedAt}</td>
                    </tr>
                </tbody>
            </table>
        ))}
    </div>
  )
}

export default Posts