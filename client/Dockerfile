FROM node:18-alpine

# Set the working directory
WORKDIR /usr/src/client

# Copy package files and install dependencies
COPY package.json package-lock.json ./
RUN npm install

# Copy the rest of the application files
COPY . .

# Expose Nuxt default port
EXPOSE 3000

# Start the Nuxt application
CMD ["npm", "run", "dev"]