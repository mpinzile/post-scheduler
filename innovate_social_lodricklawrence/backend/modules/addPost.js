const {PrismaClient} = require('@prisma/client');
const prisma = new PrismaClient();
const { eastAfricanDate ,eastAfricanTime } = require('./timeZone');

const AddPost = async (req,res) => {
    try {
        const {email,title,content,retrievedAt} = req.body;
        const getUserDetails = await prisma.User.findUnique({
            where:{
                email:email
            }
        });

        const userId = Number(getUserDetails.id);
        const addPost = await prisma.Post.create({
            data:{
                title:title,
                content:content,
                date:eastAfricanDate,
                createdAt:eastAfricanTime,
                retrievedAt:retrievedAt,
                userId:userId

            }
        });

        res.status(200).json({
            message:"post added successfully"
        });
    } catch (error) {
        console.log(error);
        res.status(500).json({
            message:"fail to add post"
        })
    }
}

module.exports = AddPost;