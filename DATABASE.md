# Tables

## Users - Implemented

- displayname: VARCHAR(100)
- username\* VARCHAR(40)
- password\* (hashed)
- id

#### \* Required in order to support authentication with username/password

#### Stretch

- userimage: VARCHAR(100) (random_bytes like imageId)

## Images - Not fully implemented

- description VARCHAR
- userId: INT
- imageId VARCHAR
- is_private: boolean

# Stretch

### Tags

- tag
- photoId
