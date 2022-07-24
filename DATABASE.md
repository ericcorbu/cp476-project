# Tables

## Users - Implemented

- displayname: VARCHAR(100)
- username\*: VARCHAR(50)
- password\* (hashed): VARCHAR(255)
- id: INT

#### \* Required in order to support authentication with username/password

#### Stretch

- userimage: VARCHAR(100) (random_bytes like imageId)

## Images - Implemented

- description VARCHAR(280)
- userId: INT
- imageId VARCHAR(100)
- is_private: boolean

# Stretch

### Tags

- tag
- photoId
