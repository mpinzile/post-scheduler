const {PrismaClient} = require('@prisma/client');
const prisma = new PrismaClient();
const { eastAfricanDate } = require('./timeZone');
const moment = require('moment-timezone');

const GetPost = async (req,res) => {
    try {
        const currentEastAfricanTime = moment().tz('Africa/Nairobi').format('HH:mm');
        const getPost = await prisma.Post.findMany({
            where:{
                date:eastAfricanDate,
                retrievedAt:currentEastAfricanTime
            }
        });
        res.status(200).json(getPost);

    } catch (error) {
        console.log(error);
        res.status(500).json({
            message:"failed to fetch a post"
        })
    }
}

module.exports = GetPost;