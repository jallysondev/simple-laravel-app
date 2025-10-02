const express = require('express');
const cors = require('cors');

const app = express();
app.use(cors());
app.use(express.json());

app.get('/api/orders', (req, res) => {
    res.json([
        { id: 1, product: 'Macbook Air m4', price: 7000, status: 'paid' },
        { id: 2, product: 'Iphone 17 Pro Max', price: 11000, status: 'pending' },
    ]);
});

const PORT = 3001;
app.listen(PORT, () => {
    console.log(`Mock service running on http://localhost:${PORT}`);
});
