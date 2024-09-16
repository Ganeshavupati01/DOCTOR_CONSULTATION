from flask import Flask, render_template, request
import pandas as pd
from sklearn.linear_model import LogisticRegression
from sklearn.metrics import accuracy_score
import warnings
warnings.filterwarnings('ignore')

app = Flask(__name__)

data_train = pd.read_csv("Training.csv")
data_test = pd.read_csv("Testing.csv")

data_train = data_train.drop('Unnamed: 133', axis=1)

X_train, y_train = data_train.drop('prognosis', axis=1), data_train['prognosis']

lr = LogisticRegression(multi_class='multinomial')
lr.fit(X_train, y_train)

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/predict', methods=['POST'])
def predict():
    selected_symptoms = request.form.getlist('symptoms')  # Get a list of selected symptoms
    print(selected_symptoms)
    symptoms_encoded = [1 if symptom in selected_symptoms else 0 for symptom in X_train.columns]
    predicted_disease = lr.predict([symptoms_encoded])  # Reshape as 2D array
    return f"<h2 style='color: blue; text-align: center;'>The predicted disease based on the selected symptoms is: {predicted_disease[0]}</h2>"
if __name__ == '__main__':
    app.run(debug=True)
