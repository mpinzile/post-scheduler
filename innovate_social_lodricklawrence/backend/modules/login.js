const {PrismaClient} = require('@prisma/client');
const prisma = new PrismaClient();
const bcrypt = require('bcrypt');

const UserLogin = async (req,res) => {
    try {
        const {email,password} = req.body;
        const checkUser = await prisma.User.findUnique({
            where:{
                email:email,
            }
        });

        if(!checkUser){
            res.status(400).json({
                message:"wrong username or password"
            })
        };

        const userPassword = checkUser.password;

        const isPasswordCorrect = bcrypt.compare(password,userPassword);

        if(!isPasswordCorrect){
            res.status(400).json({
                message:"wrong username or password"
            })
        };

        res.status(200).json({
            message:"login is successfully",
            checkUser
        })

    } catch (error) {
        console.log(error);
        res.status(500).json({
            message:"failed to login"
        })
    }
}

module.exports = UserLogin;