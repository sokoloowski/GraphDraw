# GraphDraw

## Usage

### Adjacency list in file

```powershell
PS D:\GraphDraw> php index.php example.json

# or

PS D:\GraphDraw> php index.php
> example.json
```

### Adjacency list directly as user input

```powershell
PS D:\GraphDraw> php index.php "[[2, 3], [0, 2, 3, 4], [1, 3, 4], [0, 4], [0]]"

# or

PS D:\GraphDraw> php index.php
> [[2, 3], [0, 2, 3, 4], [1, 3, 4], [0, 4], [0]]
```

## Input

Script takes JSON formatted adjacency list only!

## Output

Script is generating PNG image called `graph.png`, in the same directory, where `index.php` is located. List `[[2, 3], [0, 2, 3, 4], [1, 3, 4], [0, 4], [0]]` will produce the following image:
![graph](example/graph.png)
