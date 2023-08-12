import { useState } from "react";
import { useNavigate } from "react-router-dom";
function Register() {
    const [email,setEmail] = useState('');
    const [password,setPassword] = useState('');
    const navigate = useNavigate();
    const handleEmailChange = (event) => {
        setEmail(event.target.value);
    };

    const handlePasswordChange = (event) => {
        setPassword(event.target.value);
    }

    const handleSubmit = async (event) => {
        event.preventDefault();
        try {
            const response = await fetch('http://localhost:8000/register',{
                method:'POST',
                headers:{
                    'Content-Type': 'application/json'
                },
                body:JSON.stringify({
                    email:email,
                    password:password
                })
            })

            if(response.ok){
                const data = await response.json();
                alert(data.message);
                navigate('/');
            }else{
                console.log("request failed status",response.status)
            }

        } catch (error) {
            console.log(error)
        }

    }

    return (
        <div>
            <form onSubmit={handleSubmit}>
                <label>User Email</label>
                <input type="email" value={email} onChange={handleEmailChange} />
                <br /> <br />
                <label>Password</label>
                <input type="password" value={password} onChange={handlePasswordChange}/>
                <br /> <br/>
                <input type="submit" value="REGISTER" />
            </form>
        </div>
    )
}

export default Register