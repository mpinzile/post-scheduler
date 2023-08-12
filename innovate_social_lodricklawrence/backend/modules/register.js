const {PrismaClient} = require('@prisma/client');
const prisma = new PrismaClient();
const bcrypt = require('bcrypt');
const UserRegistration = async (req,res) => {
    try {
        const {email,password} = req.body;
        const checkEmail = await prisma.User.findUnique({
            where:{
                email:email
            }
        });

        if(checkEmail){
            res.status(400).json({
                message:"email is already taken"
            })
        };

        const salt = await bcrypt.genSalt(10);
        const hashedPassword = await bcrypt.hash(password.toString(),salt);

        const registerUser = await prisma.User.create({
            data:{
                email:email,
                password:hashedPassword
            }
        });

        res.status(200).json({
            message:"registration is successfull",
            registerUser

        })

    } catch (error) {
        console.log(error);
        res.status(500).json({
            message:"failed to register"
        })
    }
}

module.exports = UserRegistration