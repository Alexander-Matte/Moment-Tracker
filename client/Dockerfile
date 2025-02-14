# Use official Node.js image with Alpine
FROM node:18-alpine

# Set working directory
WORKDIR /usr/src/client

# Install dependencies separately to take advantage of Docker caching
COPY package.json package-lock.json ./
RUN npm install

# Copy all files into the container
COPY . .

# Expose Nuxt's development port
EXPOSE 3000

# Set environment variables for development
ENV NUXT_HOST=0.0.0.0
ENV NUXT_PORT=3000
ENV NODE_ENV=development

# Start Nuxt in development mode
CMD ["npm", "run", "dev"]
