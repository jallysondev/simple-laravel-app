const express = require('express');
const cors = require('cors');

const app = express();
app.use(cors());
app.use(express.json());

app.get('/api/users', (req, res) => {
    res.json([
        { id: 1, name: 'Tony Stark', age: 27 },
        { id: 2, name: 'Hulk', age: 28 },
    ]);
});

app.post('/api/users', (req, res) => {
    const user = req.body;
    user.id = Math.floor(Math.random() * 1000);
    res.status(201).json(user);
});

const PORT = 3001;
app.listen(PORT, () => {
    console.log(`Mock service running on http://localhost:${PORT}`);
});
