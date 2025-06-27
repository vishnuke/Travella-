# app.py

from flask import Flask, request, jsonify
from model import get_recommendations

app = Flask(__name__)

@app.route('/get_recommendations', methods=['POST'])
def recommend():
    data = request.json
    city = data.get("user_input")
    if not city:
        return jsonify({"error": "City is required"}), 400
    try:
        recommendations = get_recommendations(city)
        return jsonify({"recommendations": recommendations})
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)
